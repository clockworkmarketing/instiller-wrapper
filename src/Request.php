<?php

namespace ClockworkMarketing\InstillerWrapper;

class Request {

    public $api_id;
    public $api_key;


    public $api_endpoint;


    public function __construct($api_id, $api_key, $end_point = 'https://app.emailmarketingbrilliance.co.uk/rest') {

        // Setup the public vars
        $this->api_id = $api_id;
        $this->api_key = $api_key;
        $this->api_endpoint = $end_point;
    }

    /**
     * [request description]
     * @param  String $method  The type of CURL request we're going to make.
     * @param  String $request The built request URL.
     * @param  Array  $options Array of fields and values.
     * @return Array           The results returned from the API.
     */
    public function request($method, $request, $options) {

        // Initialise the cURL
        $curl = curl_init();

        // Initialise the results of the API request
        $results = array();
        $results['valid'] = false;

        // Get our API ID and Key
        $options['api_id'] = $this->api_id;
        $options['api_key'] = $this->api_key;


        // Select the request method to configure cURL
        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($options) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $options);
            }
        } else {
            // Add any post data to the query string URL
            if ($options) {
                $request = sprintf("%s?%s", $request, http_build_query($options));
            }
        }

        // Define the common cURL options
        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // Make sure the cURL request can be run
        if (($rest_response = curl_exec($curl)) === false) {
            // Return the error message for error handling
            $results['http_code'] = false;
            $results['error'] = curl_error($curl);
            return $results;
        } else {
            // We need to examine the response to see if if succeeded
            $request_info = curl_getinfo($curl);
            $results['http_code'] =  $request_info['http_code'];

            // Or if we're handling a zip file
            if ($request_info['content_type'] === 'application/zip') {
                // Build an array of file info
                $results['response']['content_length'] = $request_info['download_content_length'];
                $results['response']['content_name'] = $options['filename'] . '.zip';
                $results['response']['content_type'] = $request_info['content_type'];
                $results['response']['content'] = $rest_response;
            } else {
                // Decode the JSON response
                $results['response'] = json_decode($rest_response, true);
            }

            // Check the response code all valid requests return a 200
            if ($results['http_code'] === 200) {
                // Mark the response as valid
                $results['valid'] = true;
            }
        }

        // Close the cURL connection
        curl_close($curl);
        // Return the API request results
        return $results;
    }


    /**
     * The function to handle get requests.
     * @param  String $request The method we want to call.
     * @param  Array  $options Array of fields and values.
     * @return Array           The results returned from the request.
     */
    public function get($request, $options = array()) {
        return $this->request('GET', $this->api_endpoint . $request, $options);
    }


    /**
     * The function to handle post requests.
     * @param  String $request The method we want to call.
     * @param  Array  $options Array of fields and values.
     * @return Array           The results returned from the request.
     */
    public function post($request, $options) {
        return $this->request('POST', $this->api_endpoint . $request, $options);
    }
}
