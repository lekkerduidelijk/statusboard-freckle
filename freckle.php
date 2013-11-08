<?php
/**
 * Freckle: hours last week
 *
 * PHP Script that gets input from Freckle API to use with
 * Panic StatusBoard app for iPad
 *
 * @author: Rutger Laurman - lekkerduidelijk.nl
 */

// Define default timezone (OSX needs this)
date_default_timezone_set("Europe/Amsterdam");

// Get from date, set to past one week
$fromdate = date("Y-m-d",strtotime("-1 week"));

// Set your Freckle API token and subdomain
$token     = "YOUR_TOKEN";
$subdomain = "YOUR_SUBDOMAIN";

// Build URL
$url    = "https://".$subdomain.".letsfreckle.com/api/entries.json?search[from]=".$fromdate;
$ch     = curl_init();

// Set header with authentication token
$headers = array(
  "X-FreckleToken: ". $token
);

// Build CURL request
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

// Convert response to PHP object
$response = json_decode(curl_exec($ch));

// Config for use in loop
$currentdate = date("Y-m-d");
$totaltime   = 0;
$jsonoutput  = array();

foreach($response as $data) :

  $entry = $data->entry;
  $date  = $entry->date;
  $time  = $entry->minutes;

  // Check if entry is on same date
  if($date == $currentdate) {

    // Add to total
    $totaltime = $totaltime+$time;
  } elseif($currentdate != "") {

    // Format output with day and hours
    $jsonoutput[] = array(
      "day"    => date("D", strtotime($currentdate)),
      "hours"  => round($totaltime / 60, 2)
    );

    // Reset total time count
    $totaltime = $time;
  }

  // Set date to current date
  $currentdate = $date;

endforeach;

// Format output in JSON string
// See: http://www.panic.com/statusboard/docs/graph_tutorial.pdf
?>
{
  "graph" : {
    "title" : "Hours last week",
    "total" : true,
    "type"  : "bar",
    "refreshEveryNSeconds" : 1800,
    "yAxis" : {
      "units" : {
        "suffix" : "h"
      }
    },
    "datasequences" : [
      {
        "title" : "Freckle",
        "color" : "orange",
        "datapoints" : [
<?php foreach($jsonoutput as $s) : ?>
          {
            "title" : "<?php echo $s['day']; ?>",
            "value" : <?php echo $s['hours']; ?>,
          },
<?php endforeach ?>
        ]
      }
    ]
  }
}
