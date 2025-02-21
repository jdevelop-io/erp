<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability\Builder;

use JDevelop\Erp\Availability\Domain\Entity\Resource;

final class ResourceBuilder
{
    private string $id;

    public function withId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): Resource
    {
        return new Resource($this->id);
    }
}
