<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\GpsStatusNotification;
use Illuminate\Http\Request;

class LocationController extends Controller{

    //Toggle the user's
    public function toggleLocationTracking(User $user, bool $status){
        $user->update([
            'location_tracking_enabled' => $status,
            'last_location_updated_at' => $status ? now() : null
        ]);

        if($status){
            // Optionally send notification that tracking is enabled
            //$this->sendTrackingStatusNotification($user, true);
        }
    }

    //Updates the user's location
    public function updateUserLocation(User $user, float $latitude, float $longitude): void{
        if(!$user->location_tracking_enabled){
            return;
        }

        $user->locations()->create([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'recorderd_at' => now()
        ]);

        $this->checkCampusZone($user, $latitude, $longitude);
    }

    public function checkCampusZone(User $user, float $lat, float $lng): bool
    {   
        // Create a cache key based on the coordinates
        $cacheKey = "campus_zone_{$lat}_{$lng}";
        
        // Try to get from cache first
        return cache()->remember($cacheKey, now()->addMinutes(5), function () use ($user, $lat, $lng) {
            // Define your campus boundaries (example coordinates)
            $campusBoundary = [
                [14.700103029226469, 121.03120006346029],
                [14.70040804498204, 121.03118664483054],
                [14.701011585540712, 121.03159591307474],
                [14.701238724029565, 121.03280358986444],
                [14.700985626842453, 121.03319273016331],
                [14.700985626842453, 121.03351477730837],
                [14.700777957135486, 121.0335617425169],
                [14.700304209878638, 121.03451446531699],
                [14.699810992465672, 121.03429305790604],
                [14.699830461595297, 121.03324640468753],
                [14.699862910139572, 121.03303841590764],
                [14.69964874965136, 121.03248825203627],
                [14.699492996436248, 121.03249496135186],
                [14.699421609510082, 121.03235406572719],
                [14.699473527277789, 121.0321594955771],
                [14.699551403904977, 121.03210582105288],
                [14.699505975875113, 121.03121348209129],
                [14.699973235158268, 121.03118664483054],
                [14.7000835601212, 121.03119335414476],
                [14.700103029226469, 121.03120006346029]
            ];

            $isWithinCampus = $this->pointInPolygon([$lat, $lng], $campusBoundary);
        
            if (!$isWithinCampus) {
                $this->triggerSafetyAlert($user);
            }
        
            return $isWithinCampus;
        });
    }

    protected function triggerSafetyAlert(User $user): void
    {
        // Alert implementation
    }

    private function pointInPolygon(array $point, array $polygon): bool
    {
        $inside = false;
        $j = count($polygon) - 1;

        for ($i = 0; $i < count($polygon); $i++) {
            if (($polygon[$i][1] < $point[1] && $polygon[$j][1] >= $point[1] || $polygon[$j][1] < $point[1] && $polygon[$i][1] >= $point[1]) &&
                ($polygon[$i][0] <= $point[0] || $polygon[$j][0] <= $point[0])) {
                if ($polygon[$i][0] + ($point[1] - $polygon[$i][1]) / ($polygon[$j][1] - $polygon[$i][1]) * ($polygon[$j][0] - $polygon[$i][0]) < $point[0]) {
                    $inside = !$inside;
                }
            }
            $j = $i;
        }

        return $inside;
    }

    public function sendTrackingStatusNotification(User $user){
        $notification = "Your location is off, please turn on your GPS.";
    }

    public function checkGpsStatus(Request $request)
    {
        $user = $request->user();
        $gpsEnabled = $request->input('gps_enabled', false);
        
        // Send appropriate notification
        $user->notify(new GpsStatusNotification($gpsEnabled));
        
        return response()->json([
            'message' => $gpsEnabled 
                ? 'GPS is enabled'
                : 'Please enable GPS',
            'notification_sent' => true
        ]);
    }

    /**
     * Handle location updates from the visitor dashboard frontend
     */
    public function updateLocationFromFrontend(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        $user = $request->user();
        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];
        
        // Toggle tracking on if not already enabled
        if (!$user->user->location_tracking_enabled) {
            $this->toggleLocationTracking($user->user, true);
        }
        
        // Update user location
        $this->updateUserLocation($user->user, $latitude, $longitude);
        
        // Clear the user's location status cache
        cache()->forget("location_status_{$user->id}");
        
        // Check if inside campus with caching
        $isWithinCampus = $this->checkCampusZone($user->user, $latitude, $longitude);
        
        // Try to identify the building based on coordinates with caching
        $buildingName = $this->identifyBuilding($latitude, $longitude);
        
        return response()->json([
            'success' => true,
            'inside_campus' => $isWithinCampus,
            'building_name' => $buildingName,
            'message' => $isWithinCampus ? 'You are on campus' : 'Warning: You are outside campus boundaries'
        ]);
    }

    /**
     * Check location tracking status for a user
     */
    public function checkLocationStatus(Request $request)
    {
        $user = $request->user();
        $cacheKey = "location_status_{$user->id}";
        
        return response()->json(
            cache()->remember($cacheKey, now()->addSeconds(30), function () use ($user) {
                return [
                    'tracking_enabled' => $user->user->location_tracking_enabled ?? false,
                    'last_updated' => $user->user->last_location_updated_at
                ];
            })
        );
    }
    
    /**
     * Identify which building the user is in based on coordinates
     */
    private function identifyBuilding(float $latitude, float $longitude): string
    {
        // Create a cache key based on the coordinates
        $cacheKey = "building_location_{$latitude}_{$longitude}";
        
        // Try to get from cache first
        return cache()->remember($cacheKey, now()->addMinutes(5), function () use ($latitude, $longitude) {
            // Define building boundaries as polygons
            $buildings = [
                'New Academic Building' => [
                    [14.70120141404739, 121.03268300148409],
                    [14.701034103990906, 121.03302656177198],
                    [14.700889214598106, 121.0329598223829],
                    [14.701073774102312, 121.03258461178063],
                    [14.701205152812662, 121.03268223595529],
                ],
                'Gymnasium' => [
                    [14.700469562813325, 121.03357528078936],
                    [14.700158144951331, 121.03341338788118],
                    [14.699956091789758, 121.03379635997538],
                    [14.700270704157617, 121.03397924853522],
                    [14.700469562813325, 121.03357528078936]
                ],
                'Administration Building' => [
                    [14.700598681117, 121.03275394865807],
                    [14.700458848453081, 121.03269051909439],
                    [14.700316653477756, 121.03296762867387],
                    [14.700455278548233, 121.03303929597973],
                    [14.700598681117, 121.032757635194]
                ],
                'IK Building / Laboratory' => [
                    [14.70082344049655, 121.03226347431922],
                    [14.700685323817353, 121.03218309400268],
                    [14.700455278548233, 121.03257680683674],
                    [14.700605884042346, 121.03267269081141],
                    [14.700819791105971, 121.03226359671362]
                ],
                'CHED Building' => [
                    [14.700088050486443, 121.03313580065276],
                    [14.699864017385167, 121.0330241172652],
                    [14.69979123122559, 121.03319456520643],
                    [14.699998875503923, 121.03331075756205],
                    [14.700088050486443, 121.03314384189474]
                ],
                'KORPHIL Building' => [
                    [14.69999928141543, 121.03121723653908],
                    [14.699548622917064, 121.03121776512995],
                    [14.699571265137848, 121.03200556159078],
                    [14.700421887331117, 121.03244762822555],
                    [14.69999928141543, 121.03121723653908]
                ],
                'QCU Urban Farm Zone' => [
                    [14.70093172051935, 121.0318334776943],
                    [14.700685069428204, 121.031654171436],
                    [14.700421887331117, 121.03189982591482],
                    [14.700891058731372, 121.03226990934189],
                    [14.700935791631863, 121.03183340152282]
                ],
                'Quezon City Quarantine Zone' => [
                    [14.700354438139726, 121.03125266069407],
                    [14.700690045415016, 121.0316004758667],
                    [14.70036617805438, 121.03185739889483],
                    [14.70006339549741, 121.03143329575965],
                    [14.700362263902875, 121.03125232232543]
                ],
                'QCU Entrep Zone' => [
                    [14.70069991543923, 121.033772752005],
                    [14.700540621240407, 121.03368565872478],
                    [14.700233953632733, 121.03427883434347],
                    [14.700394504111458, 121.03436382848764],
                    [14.70069991543923, 121.03376867335925]
                ],
                'Belmonte Building' => [
                    [14.701018650021524, 121.03303994441052],
                    [14.700880794924174, 121.03295914884848],
                    [14.700739956910951, 121.03324648687345],
                    [14.700880794924174, 121.03332394317124],
                    [14.701022720234448, 121.03303990955027]
                ],
                'Old Yellow Building' => [
                    [14.700832385749536, 121.03332398538197],
                    [14.700366992093734, 121.03307785790554],
                    [14.70026516888035, 121.03323581607611],
                    [14.700735948819926, 121.03352411999839],
                    [14.700824329944695, 121.0333280849245]
                ]
            ];
            
            foreach ($buildings as $buildingName => $boundary) {
                if ($this->pointInPolygon([$latitude, $longitude], $boundary)) {
                    return $buildingName;
                }
            }
            
            return 'Unknown Location';
        });
    }
    
    /**
     * Get the campus boundary coordinates
     */
    private function getCampusBoundary(): array
    {
        return [
            [14.700103029226469, 121.03120006346029],
            [14.70040804498204, 121.03118664483054],
            [14.701011585540712, 121.03159591307474],
            [14.701238724029565, 121.03280358986444],
            [14.700985626842453, 121.03319273016331],
            [14.700985626842453, 121.03351477730837],
            [14.700777957135486, 121.0335617425169],
            [14.700304209878638, 121.03451446531699],
            [14.699810992465672, 121.03429305790604],
            [14.699830461595297, 121.03324640468753],
            [14.699862910139572, 121.03303841590764],
            [14.69964874965136, 121.03248825203627],
            [14.699492996436248, 121.03249496135186],
            [14.699421609510082, 121.03235406572719],
            [14.699473527277789, 121.0321594955771],
            [14.699551403904977, 121.03210582105288],
            [14.699505975875113, 121.03121348209129],
            [14.699973235158268, 121.03118664483054],
            [14.7000835601212, 121.03119335414476],
            [14.700103029226469, 121.03120006346029]
        ];
    }
}
