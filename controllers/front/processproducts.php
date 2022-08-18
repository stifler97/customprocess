<?php

/**
 * BINSHOPS
 *
 * @author BINSHOPS
 * @copyright BINSHOPS
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * Best In Shops eCommerce Solutions Inc.
 *
 */

class CustomprocessProcessproductsModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        $this->runProcess();
    }

    protected function runProcess()
    {
        set_time_limit(0);
        ob_start();
        $start = date('Y:m:d H:i:s');
        echo "START: {$start}";

        $id_language = Tools::getIsset('id_language') ? (int) Tools::getValue('id_language') : $this->context->language->id;
        $productCollection = new PrestashopCollection('Product', $id_language);
        $totalProducts = $productCollection->count();

        foreach ($productCollection as $key => $product) {
            // single process over list items goes here
            
            echo "<br>===<br>";
            $progress = round(($key + 1) / $totalProducts * 100, 2);

            echo "ID: {$product->id}";
            echo "<br>";
            echo "Old name: {$product->name}";
            echo "<br>";
            $newName = strtolower($product->name);
            $product->name = $newName;
            echo "New name: {$product->name}";
            echo "<br>";
            echo "Update status: {$product->update()}";
            echo "<br>";
            echo "<h2>%{$progress}</h2>";

            ob_end_flush();
            flush();
        }
        
        $end = date('Y:m:d H:i:s');
        echo "<br>END: {$end}";

        $d1 = new DateTime($start);
        $d2 = new DateTime($end);
        $interval = $d2->diff($d1);
        echo "<br>";
        echo "<h2>Duration: {$interval->format('%d days and %H:%I:%S')}</h2>";
    }
}
