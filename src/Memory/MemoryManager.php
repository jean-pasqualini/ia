<?php
namespace Memory;


class MemoryManager {

    protected $flashMemory;

    public function __construct()
    {
        $this->flashMemory = new FlashMemory();
    }

    public function getFlashMemory()
    {
        return $this->flashMemory;
    }

    public function persist()
    {
        $ds = DIRECTORY_SEPARATOR;

        $cacheMemory = __DIR__."/../../app/cache/".uniqid()."/";

        if(!file_exists($cacheMemory)) mkdir($cacheMemory);

        file_put_contents($cacheMemory."memory.dump", serialize($this));
    }
}