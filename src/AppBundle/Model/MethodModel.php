<?php

namespace AppBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;

class MethodModel
{

    private $path;
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->path = $this->container->getParameter('kernel.cache_dir');
    }

    public function createRecord($record)
    {

        if (!file_exists($this->path.'/file.json')) {
            $file = fopen($this->path.'/file.json', 'w');
            fclose($file);
        }
        $array = file_get_contents($this->path.'/file.json');
        $array = json_decode($array, true);

        $array[] = $record;

        $json = json_encode($array);

        file_put_contents($this->path.'/file.json', $json);

        return $record;
    }

    public function deleteRecord($id)
    {
        $records = file_get_contents($this->path.'/file.json');
        $records = json_decode($records, true);
        foreach ($records as $i => $record) {
            if ($record['id'] == $id) {
                unset($records[$i]);
                $records = json_encode($records);
                file_put_contents($this->path . '/file.json', $records);
                break;
            }
        }
    }

    public function showAllRecords()
    {
        $records = file_get_contents($this->path . '/file.json');
        $records = json_decode($records, true);

        return $records;
    }

    public function showRecord($id)
    {
        $records = file_get_contents($this->path . '/file.json');
        $records = json_decode($records, true);
        foreach ($records as $record) {
            if ($record['id'] == $id) {
                $data = array($id, $name = $record['name'], $record['surname']);
            }
        }
        return $data;
    }

    public function editRecord($id)
    {
        $records = file_get_contents($this->path . '/file.json');
        $records = json_decode($records, true);
        $request = file_get_contents('php://input', 'r');
        parse_str($request, $input);
        foreach ($records as $i => $record) {
            if ($record['id'] == $id) {
                $record['name'] = $input['name'];
                $record['surname'] = $input['surname'];
                $records[$i] = $record;
                $records = json_encode($records);
                file_put_contents($this->path . '/file.json', $records);
                break;
            }
        }
        return $record;
    }

    public function patchRecord($id)
    {
        $records = file_get_contents($this->path . '/file.json');
        $records = json_decode($records, true);
        $request = file_get_contents('php://input', 'r');
        parse_str($request, $input);
        foreach ($records as $i => $record) {
            if ($record['id'] == $id){
                foreach ($input as $key => $value) {
                    $record[$key] = $input[$key];
                    var_dump($record);
                }
            $records[$i] = $record;
            $records = json_encode($records);
            file_put_contents($this->path . '/file.json', $records);
            break;
            }
        }
        return $record;
    }
}
