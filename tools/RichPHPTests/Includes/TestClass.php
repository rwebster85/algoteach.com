<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichPHPTests;

final class TestClass
{
    public function __construct(
        private string $file,
        private string $class,
        private string $namespace,
        private string $path
    ) {}

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function getClassName(): string
    {
        return $this->class;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFullPath(): string
    {
        return $this->path . $this->file;
    }

    public function qualifiedClassName(): string
    {
        return (
            !empty($this->getNamespace())
            ? $this->getNamespace() . '\\' . $this->getClassName()
            : $this->getClassName()
        );
    }
}
