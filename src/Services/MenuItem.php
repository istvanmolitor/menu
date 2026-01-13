<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

class MenuItem extends Menu
{
    protected string|null $name = null;
    protected string $label;
    protected string|null $url = null;
    protected string|null $icon = null;
    protected bool $isActive = false;
    protected bool $isExternal = false;

    function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): MenuItem
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
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

    /**
     * @param string $label
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(string|null $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $icon
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return bool
     */
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

    /**
     * @param bool $isExternal
     */
    public function setIsExternal(bool $isExternal): void
    {
        $this->isExternal = $isExternal;
    }

    /**
     * @return bool
     */
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
            //'name' => $this->name,
            'title' => $this->label,
            'href' => $this->url,
            'icon' => $this->icon,
            'isActive' => $this->isActive(),
            'items' => $items,
        ];
    }
}
