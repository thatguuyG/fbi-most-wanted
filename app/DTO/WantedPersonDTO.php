<?php


namespace App\DTO;

class WantedPersonDTO
{
    public string|null $title;
    public string|null $description;
    public string|null $reward_text;
    public array|null $aliases;
    public array|null $dates_of_birth_used;
    public string|null $nationality;
    public int|null $age_min;
    public int|null $age_max;
    public int|null $height_min;
    public int|null $height_max;
    public string|null $weight;
    public string|null $eyes;
    public string|null $hair;
    public string|null $scars_and_marks;
    public string|null $locations;
    public string|null $status;
    public array|null $files;
    public array|null $images;
    public string|null $url;

    public function __construct($data)
    {
        $this->title             = $data['title'] ?? ($data['subjects'][0] ?? null);
        $this->description       = $data['description'] ?? null;
        $this->reward_text       = $data['reward_text'] ?? null;
        $this->aliases           = $data['aliases'] ?? null;
        $this->dates_of_birth_used = $data['dates_of_birth_used'] ?? null;
        $this->age_min           = $data['age_min'] ?? null;
        $this->age_max           = $data['age_max'] ?? null;
        $this->nationality       = $data['nationality'] ?? null;
        $this->height_min        = $data['height_min'] ?? null;
        $this->height_max        = $data['height_max'] ?? null;
        $this->weight            = $data['weight'] ?? null;
        $this->eyes              = $data['eyes'] ?? null;
        $this->hair              = $data['hair'] ?? null;
        $this->scars_and_marks   = $data['scars_and_marks'] ?? null;
        $this->locations         = $data['locations'] ?? null;
        $this->status            = $data['status'] ?? null;
        $this->files             = $data['files'] ?? null;
        $this->images            = $data['images'] ?? null;
        $this->url               = $data['url'] ?? null;
    }

    public static function fromArray(array $data): WantedPersonDTO
    {
        return new self($data);
    }
}
