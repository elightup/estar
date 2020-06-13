<?php
namespace EStar\Customizer\Sections;

class Link extends \WP_Customize_Section {
	public $type = 'estar-link';
	public $url = '';

	public function json() {
		$json = parent::json();
		$json['url'] = esc_url( $this->url );

		return $json;
	}

	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title" tabindex="0">
				<a href="{{{ data.url }}}" target="_blank" rel="noopener noreferrer">{{ data.title }}</a>
			</h3>
		</li>
		<?php
	}
}
