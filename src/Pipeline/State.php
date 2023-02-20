<?php

namespace Laravel\Folio\Pipeline;

class State
{
    public function __construct(
        public string $mountPath,
        public array $segments,
        public array $data = [],
        public int $currentIndex = 0
    )
    {

    }

    /**
     * Create a new state instance for the given iteration.
     */
    public function forIteration(int $iteration): State
    {
        return new static(
            $this->mountPath,
            $this->segments,
            $this->data,
            $iteration,
        );
    }

    /**
     * Create a new state instance with the given data added.
     */
    public function withData(string $key, mixed $value): State
    {
        return new static(
            $this->mountPath,
            $this->segments,
            array_merge($this->data, [$key => $value]),
            $this->currentIndex,
        );
    }

    /**
     * Get the number of URI segments that are present.
     */
    public function segmentCount(): int
    {
        return count($this->segments);
    }

    /**
     * Get the current URI segment for the given iteration.
     */
    public function currentSegment(): string
    {
        return $this->segments[$this->currentIndex];
    }

    /**
     * Determine if the current iteration is for the last segment.
     */
    public function lastSegment(): bool
    {
        return $this->currentIndex === ($this->segmentCount() - 1);
    }

    /**
     * Get the absolute path to the current directory for the given iteration.
     */
    public function absoluteDirectory(): string
    {
        return $this->mountPath.'/'.$this->relativeDirectory();
    }

    /**
     * Get the current directory for the given iteration relative to the mount path.
     */
    public function relativeDirectory(): string
    {
        return implode('/', array_slice($this->segments, 0, $this->currentIndex));
    }
}