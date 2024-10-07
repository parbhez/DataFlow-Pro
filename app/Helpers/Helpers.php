<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Predefined Messages
 */
define('FETCH_SUCCESS', 'Data retrieve successfully');
define('FETCH_FAIL', 'Opps! NO data available.');
define('VALIDATION_ERROR', 'Validation Error');
define('SUCCESS', 'Successfully created');
define('FAIL', 'Failed to create');
define('UPDATE_SUCCESS', 'Successfully updated');
define('UPDATE_FAIL', 'Failed to update');
define('SERVER_ERROR', 'Internal server error!');
define('DELETE_SUCCESS', 'Successfully deleted');
define('DELETE_FAIL', 'Failed to delete');
define('UNAUTHORIZED', 'These credentials do not match our records.');
define('PERMISSION_DENIED', 'Insufficient Permissions!');
define('PAGINATE_LIMIT', 10);
define('WEB_PAGINATE_LIMIT', 50);


if (!function_exists('initializeMpdf')) {
    function initializeMpdf()
    {
        try {
            $mpdf = new \Mpdf\Mpdf([
                'tempDir' => storage_path('app/temp'), // Temp directory
                'fontDir' => public_path('fonts/'), // Font directory
                'fontdata' => [
                    'kalpurush' => [
                        'R' => 'kalpurush.ttf',
                        'useOTL' => 0xFF,
                    ],
                ],
                'default_font' => 'kalpurush', // Default font
                'default_font_size' => 16,
            ]);

            return $mpdf;
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('PDF generation failed: ' . $e->getMessage());
            throw new \Exception('MPDF initialization failed: ' . $e->getMessage());
        }
    }
}



/**
 * common json response with datas
 */
if (!function_exists('respond')) {
    function respond($data, $key = "data", $code = 200, $status = true)
    {
        return response()->json([
            'status' => $status,
            "{$key}" => $data,
        ], $code);
    }
}
/**
 * common json success response
 */
if (!function_exists('respondSuccess')) {
    function respondSuccess($message, $data = [], $code = 200, $status = true)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}

/**
 * common json error response
 */

if (!function_exists('respondError')) {
    function respondError($message, $messages = [], $code = 500, $status = false)
    {
        $response = [
            'status' => $status,
            'message' => $message
        ];
        !empty($messages) ? $response['errors'] = $messages : null;
        return response()->json($response, $code);
    }
}


/**
 * Date Format
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'l, d F Y', $replaceBy = null)
    {
        if (!empty($date) && !empty($replaceBy)) {
            $date = str_replace('/', $replaceBy, $date);
        }
        return $date ? date($format, strtotime($date)) : null;
    }
}


/**
 * Date Time Format
 */
if (!function_exists('dateTimeFormat')) {
    function dateTimeFormat($timestamp, $format = 'F j, Y, h:i A', $replaceBy = null)
    {
        if (!empty($timestamp) && !empty($replaceBy)) {
            $timestamp = str_replace('/', $replaceBy, $timestamp);
        }

        return $timestamp ? Carbon::parse($timestamp)->format($format) : null;
    }
}


/**
 * Get Settings & store into cache
 */
if (!function_exists('settings')) {
    function settings()
    {
        return true;
    }
}

/* Get current route name */
if (!function_exists('currentRoute')) {
    function currentRoute()
    {
        return \Request::route()->getName();
    }
}

/* Get current path or url name */
if (!function_exists('currentUrlPath')) {
    function currentUrlPath()
    {
        return request()->path();
    }
}

/* Get category wise web news count */
if (!function_exists('categoryWiseNewsCount')) {
    function categoryWiseNewsCount()
    {
        return \App\Models\WebNews::select('category_id', \DB::raw('count(*) as total'))->groupBy('category_id')->get();
    }
}



if (!function_exists('manageRole')) {
    function manageRole($role)
    {
        return $role;
    }
}


// remove slash http(s) from given url
if (!function_exists('urlToStr')) {
    function urlToStr($url)
    {
        return preg_replace("#^[^:/.]*[:/]+#i", "", preg_replace("{/$}", "", config('app.url')));
    }
}

// remove slash http(s) from given url
if (!function_exists('diffOfTwoDate')) {
    function diffOfTwoDate($from, $to)
    {
        $begin = new DateTime($from);
        $end = new DateTime($to);
        return date_diff($begin, $end);
    }
}


if (!function_exists('getTitles')) {
    function getTitles(Collection $collection): string
    {
        return implode(', ', $collection->pluck('title')->toArray());
    }
}
