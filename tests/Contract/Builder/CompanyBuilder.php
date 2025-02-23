<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Contract\Builder;

use JDevelop\Erp\Contract\Domain\Entity\Company;

final class CompanyBuilder
{
    private string $id;

    public function withId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function build(): Company
    {
        return new Company($this->id);
    }
}
