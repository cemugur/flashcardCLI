<?php

namespace App\Traits;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;

trait FlashCardCreateTableTrait
{
    /**
     * Create a table and print to CLI
    */
    public function createTable(array $headers, array $values, ?string $footer = null ):void
    {
        // For ux we are adding cell seperator to table and create table
        foreach($values as $value){
            $rows[]=$value;
            $rows[]=new TableSeparator();
        }
        array_pop($rows); // remove last seperator
        $table = new Table($this->output);
        $table->setHeaders($headers)
            ->setRows($rows)
            ->setStyle("box")
            ->render();
        
        if(!is_null($footer)){
           $this->info(' '.$footer);
        }
    }
}