<?php
$current_category_mapping = array(
'Family' => 2,
'Health & Wellness' => 3,
'Style & Grooming' => 4,
'Teen' => 5,
'Pets' => 6,
'Leisure' => 7,
'Career & Education' => 8,
'Tech' => 9,
'Auto' => 10
);
function automap_labels($labels) {
	static $label_map = array(
		/*Family + parenting */
		'family + parenting' => 2,
		'family' => 2,
		'parenting' => 2,
		'children' => 2,
		'relationships' => 2,
		'holiday' => 2,
		'baby' => 2,
		/*Health + wellness*/
		'health + wellness' => 3,
		'health' => 3,
		'wellness' => 3,
		'fitness + sport' => 3,
		'fitness' => 3,
		'sport' => 3,
		'recipes' => 3,
		'nutrition' => 3,
		/* Style + grooming */
		'style + grooming' => 4,
		'style' => 4,
		'grooming' => 4,
		'beauty + grooming' => 4,
		'beauty' => 4,
		/* Leisure */
		'leisure' => 7,
		'entertainment' => 7,
		'travel' => 7,
		/* Career + education */
		'career + education' => 8,
		'career' => 8,
		'education' => 8,
		/* Auto */
		'auto' => 10,
		'cars' => 10,
		/* Tech */
		'tech' => 9,
		/* Teens */
        'teens' => 5,
		/* Pets*/
		'pets' => 6,
		'dogs' => 6,
		'cats' => 6,
		'iguanas' => 6,/* lol */
	);
	$label_ids = array();
	foreach ($labels as $label) {
		if (!isset($label_map[$label])) {
			continue;
		}
		$label_ids[$label_map[$label]] = 1;
	}
	return array_keys($label_ids);
}

class Article 
{
	public $sponsor_unit;
	public $id;
	public $category;
	public $title;
	public $description;
	public $published;
	public $updated;
	public $small_image;
	public $large_image;
	public $text;
	public $labels;
	public $byline;
	public $author_name;
	public $author_bio;
	public $author_image;
	
}

class XmlFeed 
{
	private $url;
	private $xml_object;
	
	public $title;
	public $identifier;
	public $link;
	public $description;
	public $type;
	public $sponsor_unit;
	public $copyright;
	public $publication_date;
	
	private $articles;
	
	
	public function __construct($url)
	{
		$this->url = $url;
	}
	
	public function process()
	{
		$xml = file_get_contents($this->url);
		
		$this->xml_object = simplexml_load_string(strtr(trim($xml),array('&rsquo;'=>"'",'&ldquo;'=>'"','&rdquo;'=>'"','&nbsp;'=>' ')));
		if (!$this->xml_object) return false;
		$this->title            = $this->get_single_element('/feed/title');
		$this->identifier       = $this->get_single_element('/feed/identifier');
		$this->link             = $this->get_single_element('/feed/link');
		$this->description      = $this->get_single_element('/feed/description');
		$this->type             = $this->get_single_element('/feed/type');
		$this->sponsor_unit     = $this->get_single_element('/feed/sponsorunit');
		$this->copyright        = $this->get_single_element('/feed/copyright');
		$this->publication_date = $this->get_single_element('/feed/pubDate');
		$this->articles         = $this->process_articles($this->identifier);
		return true;
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
			$article = new Article();
			$article->author_bio   = $this->get_single_element('authorbio', $item);
			$byline = $this->get_single_element('byline', $item);
			if (stripos($byline, ' for ') !== FALSE) {
				$parts = explode(' for ', $byline);
				$byline = $parts[0];
			}
			$byline = preg_replace('/^by /i','',$byline);
			if (!empty($article->author_bio)) {
				$article->author_name = $byline;
			} else {
				$article->byline = $byline;
			}
			
			$article->sponsor_unit = $this->get_single_element('sponsorunit', $item);
			$article->id           = $this->get_single_element('id', $item);
			$article->category     = $this->get_single_element('category', $item);
			$article->title        = trim(strip_tags($this->get_single_element('title', $item)));
			if ($article->title == '') {//experqa feed type
				$article->title = trim(strip_tags($this->get_single_element('question', $item)));
			}
			$article->description  = $this->get_single_element('description', $item);
			$article->author_image = $this->get_single_element('authorimage', $item);
			$article->link         = $this->get_single_element('link', $item);
			$article->published    = $this->get_single_element('published', $item);
			$article->updated      = $this->get_single_element('updated', $item);
			$article->small_image  = $this->get_single_element('smallimage', $item);
			$article->large_image  = $this->get_single_element('largeimage', $item);
			$article->text         = $this->get_single_element('text', $item);
			$temp_labels = html_entity_decode($this->get_single_element('labels',$item));
			$temp_labels = strtolower($temp_labels);
			$temp_labels = str_replace('&','+',$temp_labels);
			$temp_labels = str_replace(' and ',' + ',$temp_labels);
			$article->labels       = $temp_labels === "" ? array() : automap_labels(explode(',',$temp_labels));
			
			$articles[$feed_id.$article->id] = $article;
		}
		return $articles;
	}
	
	public function get_articles() {
		return $this->articles;
	}
}

?>