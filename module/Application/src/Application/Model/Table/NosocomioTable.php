<?php

namespace Application\Model\Table;

use Zend\Db\Sql\Sql;
use Base\Db\Table\AbstractTable;

class NosocomioTable extends AbstractTable
{


    public function getAllNosocomio()
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from($this->table)
                ->columns(array('institucion','direccion','lat' => 'norte', 'lng'=>'este'));
        return $this->fetchAll($select);
    }
}
