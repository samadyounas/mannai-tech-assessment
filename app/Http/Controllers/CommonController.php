<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function objective4(){

        $scores = collect ([
            ['score' => 76, 'team' => 'A'],
            ['score' => 62, 'team' => 'B'],
            ['score' => 82, 'team' => 'C'],
            ['score' => 86, 'team' => 'D'],
            ['score' => 91, 'team' => 'E'],
            ['score' => 67, 'team' => 'F'],
            ['score' => 67, 'team' => 'G'],
            ['score' => 82, 'team' => 'H'],
        ]);

        $ranks = $scores->sortByDesc('score')
        ->groupBy('score')
        ->flatMap(function ($group) {
            static $rank = 1;
            $count = $group->count();
            $rankRange = range($rank, $rank + $count - 1);
            $rank += $count;
            return $group->zip($rankRange)->map(function ($item) {
                return ['team' => $item[0]['team'], 'rank' => $item[1]];
            });
        });
        $responses = $ranks->each(function ($team) {
            return $responseData = [
                'Team' => $team['team'],
                'Rank' => $team['rank']
            ];
        });
        return $responses;
    }
    public function objective2(){
        $employees = collect([
            [
                'name' => 'John',
                'email' => 'john3@example.com',
                'sales' => [
                    ['customer' => 'The Blue Rabbit Company', 'order_total' => 7444],
                    ['customer' => 'Black Melon', 'order_total' => 1445],
                    ['customer' => 'Foggy Toaster', 'order_total' => 700],
                ],
            ],
            [
                'name' => 'Jane',
                'email' => 'jane8@example.com',
                'sales' => [
                    ['customer' => 'The Grey Apple Company', 'order_total' => 203],
                    ['customer' => 'Yellow Cake', 'order_total' => 8730],
                    ['customer' => 'The Piping Bull Company', 'order_total' => 3337],
                    ['customer' => 'The Cloudy Dog Company', 'order_total' => 5310],
                ],
            ],
            [
                'name' => 'Dave',
                'email' => 'dave1@example.com',
                'sales' => [
                    ['customer' => 'The Acute Toaster Company', 'order_total' => 1091],
                    ['customer' => 'Green Mobile', 'order_total' => 2370],
                ],
            ],
        ]);
        $employeeWithMaxSale = $employees->sortByDesc(function ($employee) {
            return collect($employee['sales'])->max('order_total');
        })->first();
        
        $maxSaleAmount = collect($employeeWithMaxSale['sales'])->max('order_total');
        return response()->json([
            'empName' => $employeeWithMaxSale['name'],
            'sale' => $maxSaleAmount
        ]);
    }
    public function objective3(){
        # I'm not able to import database mybe versions issues but I write query accordingly
        $customer = Customer::join('orders', 'customers.customerNumber', '=', 'orders.customerNumber')
            ->groupBy('customers.customerNumber')
            ->orderByDesc(\DB::raw('SUM(orders.priceEach * orders.quantityOrdered)'))
            ->select('customers.*')
            ->first();
        return $customer;
        #findCustomerWithMostOrders()
        $customer = Customer::join('orders', 'customers.customerNumber', '=', 'orders.customerNumber')
            ->groupBy('customers.customerNumber')
            ->orderByDesc(\DB::raw('COUNT(orders.orderNumber)'))
            ->select('customers.*')
            ->first();

        return $customer;
        #OR
        $customer = DB::select("
            SELECT c.*
            FROM customers c
            INNER JOIN (
                SELECT customerNumber, SUM(priceEach * quantityOrdered) AS totalSpending
                FROM orders
                GROUP BY customerNumber
                ORDER BY totalSpending DESC
                LIMIT 1
            ) o ON c.customerNumber = o.customerNumber
            LIMIT 1
        ");

        return $customer[0] ?? null;
    }
}
