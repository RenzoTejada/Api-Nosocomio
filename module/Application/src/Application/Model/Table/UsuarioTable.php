<?php

namespace Application\Model\Table;

use Zend\Db\Sql\Sql;
use Base\Db\Table\AbstractTable;

class UsuarioTable extends AbstractTable
{

    public function guardarUsuario($param)
    {
        return $this->_guardar($param);
    }

    public function buscarUsuario($email)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from($this->table)
                ->columns(array('id'))
                ->where(array('email' => $email));
        return $this->fetchOne($select);
    }

    public function validarUsuario($email, $password)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select()
                ->from($this->table)
                ->columns(array('id','name','email'))
                ->where(array('email' => $email, 'password' => $password));
        return $this->fetchRow($select);
    }

}
