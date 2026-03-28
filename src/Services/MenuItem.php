<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

class MenuItem extends Menu
{
    protected ?string $name = null;

    protected string $label;

    protected ?string $url = null;

    protected ?string $icon = null;

    protected bool $isActive = false;

    protected bool $isExternal = false;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function setName(?string $name): MenuItem
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getByName(string $name): ?MenuItem
    {
        if ($this->name === $name) {
            return $this;
        }

        return parent::getByName($name);
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isActive(): bool
    {
        if ($this->isActive) {
            return true;
        }

        return url()->current() == $this->url;
    }

    public function setActiveByName(array|string $name): void
    {
        if (is_array($name) && in_array($this->name, $name)) {
            $this->setIsActive(true);
        } elseif (is_string($name) && $this->name == $name) {
            $this->setIsActive(true);
        }
        parent::setActiveByName($name);
    }

    public function setIsExternal(bool $isExternal): void
    {
        $this->isExternal = $isExternal;
    }

    public function isExternal(): bool
    {
        return $this->isExternal;
    }

    public function toArray(): array
    {
        $items = [];
        foreach ($this->menuItems as $menuItem) {
            $items[] = $menuItem->toArray();
        }

        return [
            // 'name' => $this->name,
            'title' => $this->label,
            'href' => $this->url,
            'icon' => $this->icon,
            'isActive' => $this->isActive(),
            'items' => $items,
        ];
    }
}
