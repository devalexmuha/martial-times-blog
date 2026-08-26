<?php
namespace App\Model;

class PageModel {
  function __construct(
  public int $id,
  public string $name,
  public string $slug,
  public string $text,
  public string $date_published,
  public string $date_updated,
  public string $author,
  public string $image_url,
  ){}
}