<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class SavedInputForm
{
    //private $searchValue;
    private $parametr;
    public function __construct()
    {
        $session = new Session();

        if (!$session->get('postSearch') && (isset($_POST['go']))) {
            $this->parametr = $_POST['go'];
            $session->set('postSearch', $_POST['go']);
        } elseif ($session->get('postSearch') && (isset($_POST['go']) && ($_POST['go'] != ''))) {
            $this->parametr = $_POST['go'];
            $session->set('postSearch', $_POST['go']);
        } elseif ($session->get('postSearch') && (isset($_POST['go']) && ($_POST['go'] == ''))) {
            $this->parametr = ' ';
            $session->set('postSearch', ' ');
        } elseif ($session->get('postSearch') && (!isset($_POST['go']))) {
            $this->parametr = $session->get('postSearch');
        }
    }
    public function getValue()
    {
        return $this->parametr;
    }
}
