<?php

namespace reblex\Post\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\Post\Post;
use \reblex\Tag\Tag;
use \reblex\User\User;
use \reblex\PostTag\PostTag;

/**
 * Example of FormModel implementation.
 */
class CreatePostForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $user)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create Post"
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value"       => $user->id
                ],

                "content" => [
                    "type"        => "textarea",
                    "class"       => "postTextArea"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }

    /**
     * Find all hashtags in content and return an array with the tag names.
     *
     * @return array all hashtag names
     */
    public function findTags()
    {
        $regex = "/(?:\s|[\.\!\?]+)\#([A-z]+)/";
        $matches = [];
        preg_match_all($regex, $this->form->value("content"), $matches);
        $matches = isset($matches[1]) ? $matches[1] : [];
        return $matches;
    }

    /**
     * Check that all tags meet the requirements(max 20 characters).
     *
     * @return bool True if all tags are correct, else false.
     */
    public function tagsOk($tagNames)
    {
        $res = true;
        foreach ($tagNames as $tag) {
            if (strlen($tag) > 20) {
                $res = false;
                break;
            }
        }
        return $res;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean false if error, else redirects.
     */
    public function callbackSubmit()
    {
        $db = $this->di->get("db");

        $tagNames = $this->findTags();

        // Get all tags and check validity.
        if (!$this->tagsOk($tagNames)) {
            $this->form->addOutput("Tags can be maximum 20 characters!");
            $this->form->rememberValues();
            return false;
        }

        $post = new Post();
        $post->setDb($this->di->get("db"));
        $post->userId  = $this->form->value("userId");
        $post->content = $this->form->value("content");

        $date = new \DateTime("now", new \DateTimeZone('Europe/Stockholm'));
        $post->datetime = $date->format("Y-m-d H:i:s");

        $post->save();

        // Get the post to find generated ID.
        $post->find("id", $db->lastInsertId());

        // Save all (new) tags and Create
        // Post-Tag links in PostTag table.
        foreach ($tagNames as $tagName) {
            $tag = new Tag();
            $tag->setDb($db);
            $tag->name = $tagName;
            $tag->save();

            // Get the tag to find generated ID
            $tag->find("name", $tagName);

            $postTag = new PostTag();
            $postTag->setDb($db);
            $postTag->postId = $post->id;
            $postTag->tagId = $tag->id;
            $postTag->save();
        }

        $this->di->get("response")->redirect("posts");
    }
}
