<?php
class Article 
{
	private $sponsor_unit;
	private $id;
	private $category;
	private $title;
	private $description;
	private $byline;
	private $published;
	private $updated;
	private $small_image;
	private $large_image;
	private $text;
	private $labels;
	
	public function __construct($sponsor_unit, $id, $category, $title,
			$description, $byline, $published, $updated, $small_image,
			$large_image, $labels, $text)
	{
		$this->sponsor_unit = $sponsor_unit;
		$this->id = $id;
		$this->category = $category;
		$this->title = $title;
		$this->description = $description;
		$this->byline = $byline;
		$this->published = $published;
		$this->updated = $updated;
		$this->small_image = $small_image;
		$this->large_image = $large_image;
		$this->labels = $labels;
		$this->text = $text;
	}
	
	public function get_sponsor_unit()
	{
		return $this->sponsor_unit;
	}
	public function get_id()
	{
		return $this->id;
	}
	public function get_category()
	{
		return $this->category;
	}
	public function get_title()
	{
		return $this->title;
	}
	public function get_description()
	{
		return $this->description;
	}
	public function get_byline()
	{
		return $this->byline;
	}
	public function get_published()
	{
		return $this->published;
	}
	public function get_updated()
	{
		return $this->updated;
	}
	public function get_small_image()
	{
		return $this->small_image;
	}
	public function get_large_image()
	{
		return $this->large_image;
	}
	public function get_labels()
	{
		return $this->labels;
	}
	public function get_text()
	{
		return $this->text;
	}
	
}

class XmlFeed 
{
	private $url;
	private $xml_object;
	
	private $title;
	private $identifier;
	private $link;
	private $description;
	private $type;
	private $sponsor_unit;
	private $copyright;
	private $publication_date;
	
	private $articles;
	
	
	public function __construct($url)
	{
		$this->url = $url;
	}
	
	public function process()
	{
		$xml = file_get_contents($this->url);
		
		$this->xml_object = simplexml_load_string(trim($xml));
		$this->title            = $this->get_single_element('/feed/title');
		$this->identifier       = $this->get_single_element('/feed/identifier');
		$this->link             = $this->get_single_element('/feed/link');
		$this->description      = $this->get_single_element('/feed/description');
		$this->type             = $this->get_single_element('/feed/type');
		$this->sponsor_unit     = $this->get_single_element('/feed/sponsorunit');
		$this->copyright        = $this->get_single_element('/feed/copyright');
		$this->publication_date = $this->get_single_element('/feed/pubDate');
		$this->articles         = $this->process_articles($this->identifier);
	}
	
	private function get_single_element($xpath, $xml_object = null)
	{
		if ($xml_object === null)
			$xml_object = $this->xml_object;
		$elements = $xml_object->xpath($xpath);
		if (!empty($elements))
			return dom_import_simplexml($elements[0])->textContent;
		else
			return "";
	}
	
	private function process_articles($feed_id)
	{
		$articles = array();
		$items = $this->xml_object->xpath('/feed/item');
		
		foreach ($items as $item)
		{
			$sponsor_unit = $this->get_single_element('sponsorunit', $item);
			$id           = $this->get_single_element('id', $item);
			$category     = $this->get_single_element('category', $item);
			$title        = $this->get_single_element('title', $item);
			$description  = $this->get_single_element('description', $item);
			$byline       = $this->get_single_element('byline', $item);
			$link         = $this->get_single_element('link', $item);
			$published    = $this->get_single_element('published', $item);
			$updated      = $this->get_single_element('updated', $item);
			$small_image  = $this->get_single_element('smallimage', $item);
			$large_image  = $this->get_single_element('largeimage', $item);
			$text         = $this->get_single_element('text', $item);
			$temp_labels  = $this->get_single_element('labels',$item);
			$labels       = $temp_labels === "" ? array() : explode(',',$temp_labels);
			$article = 	new Article($sponsor_unit, $id, $category, $title,
								$description, $byline, $published, $updated, $small_image,
								$large_image, $labels, $text);
			$articles[$feed_id.$id] = $article;
		}
		return $articles;
	}
	
	public function get_title()
	{
		return $this->title;
	}

	public function get_identifier()
	{
		return $this->identifier;
	}

	public function get_link()
	{
		return $this->link;
	}

	public function get_description()
	{
		return $this->description;
	}

	public function get_type()
	{
		return $this->type;
	}

	public function get_sponsor_unit()
	{
		return $this->sponsor_unit;
	}

	public function get_copyright()
	{
		return $this->copyright;
	}

	public function get_publication_date()
	{
		return $this->publication_date;
	}
	
	public function get_articles()
	{
		return $this->articles;
	}
}

?>