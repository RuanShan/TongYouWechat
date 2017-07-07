<?php

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class TagController extends WechatBaseController
{
    public function index()
    {
        $app = new Application($this->options);
        $tag_api = $app->user_tag;

        $tags = $tag_api->lists();
        // {
        //     "tags": [
        //         {
        //             "id": 0,
        //             "name": "标签1",
        //             "count": 72596
        //         },
        //         {
        //             "id": 1,
        //             "name": "标签2",
        //             "count": 36
        //         },
        //         ...
        //     ]
        // }
        var_dump($tags);
    }

    public function init()
    {
      $state_tags=array( "logged", "unlogged");
      $app = new Application($this->options);
      $tag_api = $app->user_tag;
      $tags = $tag_api->lists();

      $has_tag = false;
      foreach ($tags->tags as $tag) {
        if(in_array( $tag->name, $state_tags ))
        {
          $has_tag = true;
          break;
        }
      }
      if( !$has_tag )
      {
        foreach($state_tags as $name) {
         $tag_api->create($name);
        }
        $tags = $tag_api->lists();
      }
      var_dump($tags);
    }
}
