<?php
namespace App\Http\Controllers;

require_once __DIR__ . "/database/factories/Database.php";
require_once __DIR__ . "/database/factories/DatabaseFactory.php";

use DatabaseFactory;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Controllers\Exception;
use App\Http\Controllers\PDOexception;
use App\Http\Controllers\RuntimeException;

use function PHPUnit\Framework\throwException;

class VisitController extends Controller
{
    private $db;
    private $activeVisits = []; // Tracks active visits in memory

    public function __construct() {
        $config = require '/database/factories/config.php';
        $this->db = DatabaseFactory::create($config);
    }

    /**
     * Handle visit tracking (entry, updates, exit)
     * 
     * @param int $userId
     * @param float $latitude
     * @param float $longitude
     * @param string $action (enter|update|exit)
     * @return array
     */
    public function trackVisit($user_id, $latitude, $longitude, $action = 'update') {
        try {
            // Validate inputs
            if (!is_numeric($user_id) || $user_id <= 0) {
                throw new InvalidArgumentException("Invalid user ID");
            }
            
            if (!is_numeric($latitude) || !is_numeric($longitude)) {
                throw new InvalidArgumentException("Invalid coordinates");
            }

            $pdo = $this->db->getConnection();
            $response = [];

            switch ($action) {
                case 'enter':
                    // Record new visit entry
                    $stmt = $pdo->prepare("
                        INSERT INTO tbl_visit 
                        (user_id, visit_date, entry_time, exit_time, location) 
                        VALUES (?, CURDATE(), CURTIME(), NULL, 
                            (SELECT id FROM tbl_locations 
                             WHERE ROUND(latitude, 5) = ROUND(?, 5)
                             AND ROUND(longitude, 5) = ROUND(?, 5)
                             LIMIT 1)
                    ");
                    
                    $stmt->execute([$user_id, $latitude, $longitude]);
                    $visit_id = $pdo->lastInsertId();
                    
                    // Store active visit in memory
                    $this->activeVisits[$user_id] = $visit_id;
                    
                    $response = [
                        'status' => 'entry_recorded',
                        'visit_id' => $visit_id,
                        'timestamp' => date('Y-m-d H:i:s')
                    ];
                    break;

                case 'update':
                    if (!isset($this->activeVisits[$user_id])) {
                        // No active visit - treat as new entry
                        return $this->trackVisit($user_id, $latitude, $longitude, 'enter');
                    }
                    
                    // Update location for active visit
                    $stmt = $pdo->prepare("
                        UPDATE tbl_visit 
                        SET location = (
                            SELECT id FROM tbl_locations 
                            WHERE ROUND(latitude, 5) = ROUND(?, 5)
                            AND ROUND(longitude, 5) = ROUND(?, 5)
                            LIMIT 1
                        )
                        WHERE visit_id = ? AND exit_time IS NULL
                    ");
                    
                    $stmt->execute([$latitude, $longitude, $this->activeVisits[$user_id]]);
                    
                    $response = [
                        'status' => 'location_updated',
                        'visit_id' => $this->activeVisits[$user_id],
                        'timestamp' => date('Y-m-d H:i:s')
                    ];
                    break;

                case 'exit':
                    if (!isset($this->activeVisits[$user_id])) {
                        throw new \RuntimeException("No active visit to exit");
                    }
                    
                    // Record exit time
                    $stmt = $pdo->prepare("
                        UPDATE tbl_visit 
                        SET exit_time = CURTIME() 
                        WHERE visit_id = ? AND exit_time IS NULL
                    ");
                    
                    $stmt->execute([$this->activeVisits[$user_id]]);
                    
                    // Remove from active visits
                    unset($this->activeVisits[$user_id]);
                    
                    $response = [
                        'status' => 'exit_recorded',
                        'visit_id' => $this->activeVisits[$user_id],
                        'timestamp' => date('Y-m-d H:i:s')
                    ];
                    break;

                default:
                    throw new InvalidArgumentException("Invalid action specified");
            }

            return $response;

        } catch (\PDOException $e) {
            error_log("Database error in trackVisit: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Get active visits (for debugging/monitoring)
     */
    public function getActiveVisits() {
        return $this->activeVisits;
    }
}

// Example usage (would typically be called from an API endpoint)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    
    try {
        $tracker = new VisitController();
        
        $user_id = $_POST['user_id'] ?? 0;
        $latitude = $_POST['latitude'] ?? 0;
        $longitude = $_POST['longitude'] ?? 0;
        $action = $_POST['action'] ?? 'update'; // Default to update
        
        // Validate required fields
        if (empty($user_id) || empty($latitude) || empty($longitude)) {
            throw new InvalidArgumentException("Missing required parameters");
        }
        
        $result = $tracker->trackVisit($user_id, $latitude, $longitude, $action);
        echo json_encode($result);
        
    } catch (\Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
