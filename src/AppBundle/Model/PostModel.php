<?php

namespace AppBundle\Model;

use AppBundle\Entity\Post;

/**
 * Class PostModel.
 */
class PostModel
{
    /**
     * Save new post in storage.
     *
     * @param Post   $post     - new post object
     * @param string $filename - storage
     *
     * @return array|mixed
     */
    public function save(Post $post, string $filename)
    {
        $model = new RandomDataModel();
        $image = $model->getImages(1);
        $post->setImage($image[0]);
        $post = serialize($post);
        if (file_exists($filename)) {
            chmod($filename, 0777);
            $content = file_get_contents($filename);
            if ($content !== '') {
                $new_array = json_decode($content, true);
            }
        }
        $new_array[] = $post;
        $fp = fopen($filename, 'w');
        fwrite($fp, json_encode($new_array));
        fclose($fp);

        return $new_array;
    }

    /**
     * Get all posts from storage.
     *
     * @param string $filename - storage
     *
     * @return mixed|null
     */
    public function get(string $filename)
    {
        if (file_exists($filename)) {
            chmod($filename, 0777);
            $content = file_get_contents($filename);
            if ($content !== '') {
                $new_array = json_decode($content, true);
                for ($i = 0; $i < count($new_array); ++$i) {
                    $new_array[$i] = unserialize($new_array[$i]);
                }
            } else {
                $new_array = null;
            }
        } else {
            $new_array = null;
        }

        return $new_array;
    }
}
