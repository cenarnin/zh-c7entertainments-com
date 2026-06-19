<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $image;
    private string $domain;

    public function __construct(string $url, string $title, string $description = '', string $image = '')
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->domain = parse_url($url, PHP_URL_HOST) ?? '';
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public function render(): string
    {
        $escapedUrl = $this->escape($this->url);
        $escapedTitle = $this->escape($this->title);
        $escapedDescription = $this->escape($this->description);
        $escapedImage = $this->escape($this->image);
        $escapedDomain = $this->escape($this->domain);

        $html = '<div class="link-card">';
        $html .= '<a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer">';

        if (!empty($this->image)) {
            $html .= '<div class="link-card-image">';
            $html .= '<img src="' . $escapedImage . '" alt="' . $escapedTitle . '" loading="lazy" />';
            $html .= '</div>';
        }

        $html .= '<div class="link-card-content">';
        $html .= '<span class="link-card-domain">' . $escapedDomain . '</span>';
        $html .= '<h3 class="link-card-title">' . $escapedTitle . '</h3>';

        if (!empty($this->description)) {
            $html .= '<p class="link-card-description">' . $escapedDescription . '</p>';
        }

        $html .= '</div>';
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }

    public static function createDefault(): self
    {
        return new self(
            'https://zh-c7entertainments.com',
            'c7娱乐',
            'c7娱乐是一家专注于在线娱乐服务的平台',
            'https://zh-c7entertainments.com/images/logo.png'
        );
    }

    public function __toString(): string
    {
        return $this->render();
    }
}

function renderLinkCard(string $url, string $title, string $description = '', string $image = ''): string
{
    $card = new LinkCard($url, $title, $description, $image);
    return $card->render();
}

$sampleData = [
    'url' => 'https://zh-c7entertainments.com',
    'title' => 'c7娱乐',
    'description' => '提供丰富多样的在线娱乐体验',
    'image' => 'https://zh-c7entertainments.com/thumb.jpg',
];

$demoCard = new LinkCard(
    $sampleData['url'],
    $sampleData['title'],
    $sampleData['description'],
    $sampleData['image']
);

echo $demoCard;