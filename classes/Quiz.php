<?php
class Quiz
{
    private ?int $id;
    private ?string $header;
    private ?string $description;
    private ?bool $active;

    public function __construct(?int $id = null, ?string $header = null, ?string $description = null, ?bool $active = null)
    {
        $this->id = $id;
        $this->header = $header;
        $this->description = $description;
        $this->active = $active;
    }

    public static function Quiz($object): Quiz
    {
        return new Quiz($object["id"], $object["header"], $object["description"], $object["active"]);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getHeader()
    {
        return $this->header;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getActive()
    {
        return $this->active;
    }
}
