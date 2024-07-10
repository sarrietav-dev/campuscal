<?php

namespace App\Http\Controllers;

use App\Exports\BookingExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExportBookingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $exportName = Str::uuid().'.xlsx';
        (new BookingExport)->queue($exportName, "s3")->chain([
            new NotifyUserOfCompletedExport($request->user(), $exportName),
        ]);

        return back()->with('message', __('Exporting the data. You will be notified once it is ready.'));
    }
}
