<?php
namespace Almhdy\Simy\Core;

class Pagination
{
  private int $totalItems; // Total number of items
  private int $itemsPerPage; // Items per page
  private int $currentPage; // Current page number
  private int $totalPages; // Total pages

  public function __construct(
    int $totalItems,
    int $itemsPerPage = 10,
    int $currentPage = 1
  ) {
    // Initialize properties
    $this->totalItems = $totalItems;
    $this->itemsPerPage = $itemsPerPage;
    $this->currentPage = $currentPage;

    // Calculate total pages
    $this->totalPages = (int) ceil($this->totalItems / $this->itemsPerPage);
  }

  public function getCurrentPage(): int
  {
    return $this->currentPage;
  }

  public function getTotalPages(): int
  {
    return $this->totalPages;
  }

  public function hasNext(): bool
  {
    return $this->currentPage < $this->totalPages;
  }

  public function hasPrevious(): bool
  {
    return $this->currentPage > 1;
  }

  public function getNextPage(): ?int
  {
    return $this->hasNext() ? $this->currentPage + 1 : null;
  }

  public function getPreviousPage(): ?int
  {
    return $this->hasPrevious() ? $this->currentPage - 1 : null;
  }

  public function getStartItem(): int
  {
    return ($this->currentPage - 1) * $this->itemsPerPage + 1;
  }

  public function getEndItem(): int
  {
    return min($this->totalItems, $this->currentPage * $this->itemsPerPage);
  }

  public function createLinks(string $baseUrl): string
  {
    $links = "";

    if ($this->hasPrevious()) {
      $links .=
        '<a href="' .
        $baseUrl .
        "?page=" .
        $this->getPreviousPage() .
        '">Previous</a> ';
    }

    for ($i = 1; $i <= $this->totalPages; $i++) {
      if ($i == $this->currentPage) {
        $links .= "<strong>" . $i . "</strong> ";
      } else {
        $links .= '<a href="' . $baseUrl . "?page=" . $i . '">' . $i . "</a> ";
      }
    }

    if ($this->hasNext()) {
      $links .=
        '<a href="' . $baseUrl . "?page=" . $this->getNextPage() . '">Next</a>';
    }

    return $links;
  }
}
