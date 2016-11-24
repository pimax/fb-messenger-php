<?php
namespace pimax\Messages;
/**
 * Class AccountLink
 * @package pimax\Messages
 */
class AccountLink
{
	/**
	 * Link Account title
	 *
	 * @var null|string
	 */
	protected $title = null;
	/**
	 * Button url
	 *
	 * @var null|string
	 */
	protected $url = null;
	/**
	 * Image url
	 * 
	 * @var null|string
	 */
	protected $image_url = null;
	/**
	 * Subtitle
	 * @var null|string 
	 */
	protected $subtitle = null;
	/**
	 * AccountLink constructor.
	 *
	 * @param string $title
	 * @param string $subtitle
	 * @param string $url button url
	 * @param string $image_url
	 */
	public function __construct($title, $subtitle = '', $url = '', $image_url = '')
	{
		$this->title = $title;
		$this->subtitle = $subtitle;
		$this->url = $url;
		$this->image_url = $image_url;
	}
	/**
	 * Get AccountLink data
	 * 
	 * @return array
	 */
	public function getData()
	{
		$buttons = new MessageButton( MessageButton::TYPE_ACCOUNT_LINK, '', $this->url );
		$result = [
			'title' => $this->title,
			'subtitle' => $this->subtitle,
			'image_url' => $this->image_url,
			'buttons' => [$buttons->getData()]
		];
		return $result;
	}
}