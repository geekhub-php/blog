<?php

namespace AppBundle\Repository;

use Faker;

/**
 * Class Storage.
 */
class Storage
{
    /**
     * @var string
     */
    private $dbTablePath;

    /**
     * @param string $dbTable
     */
    protected function setupDb($dbTable)
    {
        $this->dbTablePath = '../var/cache/db/'.$dbTable.'.json';

        $data = [
            'auto_id' => 1,
        ];

        if (!file_exists($this->dbTablePath)) {
            mkdir('../var/cache/db');

            $faker = Faker\Factory::create();

            for ($i = 0; $i <= 15; $i++) {
                if ($dbTable == 'posts') {
                    $data[] = [
                        'id' => $data['auto_id'],
                        'title' => $faker->text(20),
                        'content' => $faker->text
                    ];
                }
                ++$data['auto_id'];
            }

            file_put_contents($this->dbTablePath, json_encode($data));
        }
    }

    /**
     * @param string $dbTable
     *
     * @return mixed
     */
    public function getData($dbTable)
    {
        $this->setupDb($dbTable);

        return json_decode(file_get_contents($this->dbTablePath), true);
    }

    /**
     * @param string $dbTable
     * @param array  $data
     *
     * @return bool
     */
    public function setData($dbTable, $data)
    {
        $this->setupDb($dbTable);

        file_put_contents($this->dbTablePath, json_encode($data));

        return true;
    }
}
