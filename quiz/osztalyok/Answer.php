<?php
class Answer
{
    private ?int $id;
    private ?int $question_id;
    private ?string $content;
    private ?bool $is_right;

    public function __construct(?int $id = null, ?int $question_id = null, ?string $content = null, ?bool $is_right = null)
    {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->content = $content;
        $this->is_right = $is_right;
    }

    public static function Answer($object): Answer
    {
        return new Answer($object["id"], $object["question_id"], $object["content"], $object["is_right"]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getQuestionId()
    {
        return $this->question_id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getIsRight()
    {
        return $this->is_right;
    }
}
