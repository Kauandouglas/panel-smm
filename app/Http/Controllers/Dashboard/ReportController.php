<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function order()
    {
        // Get order data
        $orders = DB::table('orders')
            ->select(DB::raw('COUNT(*) as total, MONTH(created_at) as month, DAY(created_at) as day'))
            ->groupBy('month', 'day')
            ->whereYear('created_at', '2023')
            ->get();

        // Organize the data in the appropriate structure
        $orderTable = [];
        $months = range(1, 12);
        $days = range(1, 31);

        foreach ($orders as $order) {
            $month = $order->month;
            $day = $order->day;
            $quantity = $order->total;

            $orderTable[$month][$day] = $quantity;
        }

        // Fill in empty entries with zero value
        foreach ($months as $month) {
            foreach ($days as $day) {
                foreach ($orderTable as $data) {
                    if (!isset($orderTable[$month][$day])) {
                        $orderTable[$month][$day] = 0;
                    }
                }
            }
        }

        ksort($orderTable);

        return view('dashboard.reports.order', [
            'orderTable' => $orderTable,
            'days' => $days
        ]);
    }

    public function payment()
    {
        // Get order data
        $payments = DB::table('payments')
            ->select(DB::raw('SUM(price) as total, MONTH(created_at) as month, DAY(created_at) as day, status'))
            ->groupBy('month', 'day')
            ->whereYear('created_at', '2023')
            ->where('status', true)
            ->get();

        // Organize the data in the appropriate structure
        $paymentTable = [];
        $months = range(1, 12);
        $days = range(1, 31);

        foreach ($payments as $payment) {
            $month = $payment->month;
            $day = $payment->day;
            $quantity = $payment->total;

            $paymentTable[$month][$day] = $quantity;
        }

        // Fill in empty entries with zero value
        foreach ($months as $month) {
            foreach ($days as $day) {
                foreach ($paymentTable as $data) {
                    if (!isset($paymentTable[$month][$day])) {
                        $paymentTable[$month][$day] = 0;
                    }
                }
            }
        }

        ksort($paymentTable);

        return view('dashboard.reports.payment', [
            'paymentTable' => $paymentTable,
            'days' => $days
        ]);
    }

    public function ticket()
    {
        // Get order data
        $tickets = DB::table('supports')
            ->select(DB::raw('COUNT(*) as total, MONTH(created_at) as month, DAY(created_at) as day'))
            ->groupBy('month', 'day')
            ->whereYear('created_at', '2023')
            ->get();

        // Organize the data in the appropriate structure
        $ticketTable = [];
        $months = range(1, 12);
        $days = range(1, 31);

        foreach ($tickets as $ticket) {
            $month = $ticket->month;
            $day = $ticket->day;
            $quantity = $ticket->total;

            $ticketTable[$month][$day] = $quantity;
        }

        // Fill in empty entries with zero value
        foreach ($months as $month) {
            foreach ($days as $day) {
                foreach ($ticketTable as $data) {
                    if (!isset($ticketTable[$month][$day])) {
                        $ticketTable[$month][$day] = 0;
                    }
                }
            }
        }

        ksort($ticketTable);

        return view('dashboard.reports.ticket', [
            'ticketTable' => $ticketTable,
            'days' => $days
        ]);
    }

    public function profit()
    {
        // Get order data
        $orders = DB::table('orders')
            ->select(DB::raw('SUM(profit) as total, MONTH(created_at) as month, DAY(created_at) as day'))
            ->groupBy('month', 'day')
            ->where('status_id', 4)
            ->whereYear('created_at', '2023')
            ->get();

        // Organize the data in the appropriate structure
        $orderTable = [];
        $months = range(1, 12);
        $days = range(1, 31);

        foreach ($orders as $order) {
            $month = $order->month;
            $day = $order->day;
            $quantity = $order->total;

            $orderTable[$month][$day] = $quantity;
        }

        // Fill in empty entries with zero value
        foreach ($months as $month) {
            foreach ($days as $day) {
                foreach ($orderTable as $data) {
                    if (!isset($orderTable[$month][$day])) {
                        $orderTable[$month][$day] = 0;
                    }
                }
            }
        }

        ksort($orderTable);

        return view('dashboard.reports.profit', [
            'orderTable' => $orderTable,
            'days' => $days
        ]);
    }
}
