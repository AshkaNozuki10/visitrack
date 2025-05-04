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
        // Define your campus boundaries (example coordinates)
        $campusBounds = [
            'min_lat' => 12.3456,
            'max_lat' => 12.3567,
            'min_lng' => 98.7654,
            'max_lng' => 98.7765
        ];

        $isWithinCampus = ($lat >= $campusBounds['min_lat'] && 
                          $lat <= $campusBounds['max_lat']) &&
                          ($lng >= $campusBounds['min_lng'] && 
                          $lng <= $campusBounds['max_lng']);
    
        if (!$isWithinCampus) {
            $this->triggerSafetyAlert($user);
        }
    
        return $isWithinCampus;
    }

    protected function triggerSafetyAlert(User $user): void
    {
        // Alert implementation
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
    
    //Check the route and connections
    public function test(){
        return 'It is good and working';
    }
}