<?php

namespace AppBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InspectionIdRoute
{
    private $authors;
    /*
     * param array, int id
     * return error, user not admin role or not be autors this data
     */
    public function setValue($author, $authors, $user)
    {
        $result = 'no';
        if ($user->getRole()->getName() == 'ROLE_ADMIN') {
            $result = 'ok';
        } elseif ($author == 'null') {
            foreach ($authors as $key => $value) {
                if ($value->getId() == $user->getId()) {
                    $result = 'ok';
                }
            }
        } elseif ($authors == 'null' && $author->getId() == $user->getId()) {
            $result = 'ok';
        }

        return $this->result = $result;
    }
    public function getValue()
    {
        if ($this->result == 'no') {
            throw new NotFoundHttpException('InspectionId: sorry, this is not your post. ');
        }
    }
}
