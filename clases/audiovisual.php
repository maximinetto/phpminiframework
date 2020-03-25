<?php

require_once 'config/log.php';

abstract class AudioVisual extends ClaseBase
{
    private $idVideo, $title, $director, $poster, $year;
    private $actors;
    private $runtime, $ratings, $genre;

    public function __construct(array $attributes)
    {
        $this->idVideo = $attributes['imdbID'];

        $attributes = array_change_key_case($attributes, CASE_LOWER);
        foreach ($attributes as $key => $val) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $val;
            }
        }
    }

    abstract public function tipo();

    /**
     * Get the value of idVideo
     */
    public function getIdVideo()
    {
        return $this->idVideo;
    }

    /**
     * Set the value of idVideo
     *
     * @return  self
     */
    public function setIdVideo($idVideo)
    {
        $this->idVideo = $idVideo;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get the value of runtime
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set the value of runtime
     *
     * @return  self
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get the value of rankings
     */
    public function getRankings()
    {
        return $this->ratings;
    }

    /**
     * Set the value of rankings
     *
     * @return  self
     */
    public function setRankings($ratings)
    {
        $this->ratings = $ratings;

        return $this;
    }

    /**
     * Get the value of director
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set the value of director
     *
     * @return  self
     */
    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get the value of genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get the value of poster
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set the value of poster
     *
     * @return  self
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get the value of actors
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Set the value of actors
     *
     * @return  self
     */
    public function setActors($actors)
    {
        $this->actors = $actors;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
