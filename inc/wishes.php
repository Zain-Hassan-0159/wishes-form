<?php

/**
 * Wishes Form
 *
 * @package           Wishes Form
 * @author            Zain Hassan
 *
 */
   


/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class wishes_widget_elementore  extends \Elementor\Widget_Base {
	

	public function get_style_depends() {

		// wp_register_style( 'wishes-style', plugins_url( 'assets/css/style.css', __FILE__ ) );

		// return [
		// 	'wishes-style',
		// ];

	}
	

	/**
	 * Get widget name.
	 *
	 * Retrieve company widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wishes';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve company widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Wishes', 'wishes-form' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve company widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-heart';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the company of categories the company widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'el-wishes' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the company of keywords the company widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'wishes', 'widgets', 'custom', 'wishes widgets' ];
	}



	/**
	 * Register company widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'wishes', 'wishes-form' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			

		$this->add_control(
			'post_per_page',
			[
				'label'     => esc_html__('Posts Per Page', 'wishes-form'),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'default'       => 4,
				'step'      => 1,
			]
		);

		$this->add_control(
			'select_layout',
			[
				'label' => esc_html__( 'Select Layout', 'wishes-form' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one' => esc_html__( 'Layout One', 'wishes-form' ),
					'two'  => esc_html__( 'Layout Two', 'wishes-form' ),
				]
			]
		);
		
		$this->end_controls_section();

        $this->start_controls_section(
			'wishes_style_section',
			[
				'label' => __( 'Style', 'wishes-form' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
                'label' => __( 'Content Typography', 'wishes-form' ),
				'selector' => '{{WRAPPER}} .wishes p',
			]
		);
		
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'from_typography',
                'label' => __( 'From User Typography', 'wishes-form' ),
				'selector' => '{{WRAPPER}} .wishes .user',
				'condition' => [
					'select_layout' => 'two',
				],
			]
		);
		
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'from_typography_2',
                'label' => __( 'From User Typography', 'wishes-form' ),
				'selector' => '{{WRAPPER}} .wishes .user h4',
				'condition' => [
					'select_layout' => 'one',
				],
			]
		);
		
		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__( 'Primary Color', 'custom-location' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#454545CF',
				'selectors' => [
					'{{WRAPPER}} .wishes h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wishes p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wishes .user' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wish' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .wishes' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pagination .page-numbers' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pagination .page-numbers:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .pagination .current' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'custom-location' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#EAEAEA',
				'selectors' => [
					'{{WRAPPER}} .wishes .div-left' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .wishes .div-left:before' => 'border-color: transparent {{VALUE}} transparent transparent;',
				],
				'condition' => [
					'select_layout' => 'one',
				],
			]
		);
		
		$this->add_control(
			'card_text_color',
			[
				'label' => esc_html__( 'Card Text Color', 'custom-location' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0F0F10',
				'selectors' => [
					'{{WRAPPER}} .wishes .div-left p' => 'color: {{VALUE}};',
				],
				'condition' => [
					'select_layout' => 'one',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .wishes .div-left',
				'condition' => [
					'select_layout' => 'one',
				],
			]
		);
		
		
		$this->end_controls_section();


	}

	/**
	 * Render company widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// echo "<pre>";
		// var_dump($settings['posts_include_terms']);
        

		if($settings['select_layout'] === 'one'){
			?>
			<style>
				.div-left{
					position: relative;
					background: #87CEFA;
					max-width: 700px;
					padding: 25px;
					border-radius: 5px;
					margin: 10px;
					width: 100%;
				}
				.div-left:before{
				content:"";
				position:absolute;
				width:0px;
				height:0px;
				border: 10px solid;
				border-color: transparent #87CEFA transparent transparent;
				left:-20px;
				top:10px;
				}
				.div-right{
				position:relative;
				background:#87CEFA;  
				width:300px;
				padding:10px; 
				border-radius:5px;
				}
				.div-right:before{
					content: "";
					position: absolute;
					width: 0px;
					height: 0px;
					border: 15px solid;
					border-color: transparent #87CEFA transparent transparent;
					left: -30px;
					top: 30px;
				}
				.wishes{
					display: flex;
					gap: 30px;
					align-items: center;
					justify-content: center;
					border-bottom: 1px solid black;
					padding: 60px;   
				}
				.wishes h4{
					margin: 10px 0 0;
				}
				.wishes .wish{
					display: flex;
					gap: 20px;
					border-bottom: 1px solid black;
					padding: 60px;   
				}
				.wishes .user{
					width: 80px;
					text-align: center;
				}
				.wishes img{
				width: 80px;
				height: 80px;
				max-width: 80px;
				object-fit: cover;
				border-radius: 100%;
				}
				.wishes p{
				margin-top:0;
				margin-bottom: 30px;
				}
				/* Styling for pagination */
				.pagination {
				display: flex;
				justify-content: center;
				margin-top: 20px;
				}

				.pagination .page-numbers {
				padding: 10px;
				margin: 0 5px;
				border: 1px solid black;
				color: black;
				}

				.pagination .page-numbers:hover {
				background-color: black;
				color: white;
				}

				.pagination .current {
				background-color: black;
				color: white;
				border: none;
				}

				@media (max-width: 668px){
					.wishes{
						padding: 30px 20px;
					}

				}
				@media (max-width: 468px){
					.div-left{
						margin: 0;
					}
					.wishes{
						gap: 20px;
					}
				}
			</style>
			<div class="wishes_wrapper">
				<?php
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$the_query = new WP_Query( 
					array( 
						'posts_per_page' => $settings['post_per_page'], 
						'post_type' => 'wishes_submission',
						'paged' => $paged
					) 
				);
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<div class="wishes">
					<div class="user">
						<?php 
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( array( 80, 80 ) ); 
							}else{
								?>
								<img width="80" height="80" src="<?php echo \Elementor\Utils::get_placeholder_image_src(); ?>" alt="placeholder image of user">
								<?php
							}
						?>
						<h4><?php echo get_the_title(); ?></h4>
					</div>
					<div class="div-left">
						<p>
							<?php echo get_the_content(); ?>
						</p>
					</div>
				</div>
					<?php endwhile; ?>
					<div class="pagination">
						<?php echo paginate_links( array( 'total' => $the_query->max_num_pages ) ); ?>
					</div>
					<?php wp_reset_postdata();
				else :
					echo '<p>No wishes found.</p>';
				endif; ?>
			</div>
			<?php
		}else{
			?>
			<style>
				.wishes .wish{
					display: flex;
					gap: 20px;
					border-bottom: 1px solid black;
					padding: 60px;   
				}
				.wishes img{
				width: 80px;
				height: 80px;
				max-width: 80px;
				object-fit: cover;
				}
				.wishes p{
				margin-top:0;
				margin-bottom: 30px;
				}
				/* Styling for pagination */
				.pagination {
				display: flex;
				justify-content: center;
				margin-top: 20px;
				}

				.pagination .page-numbers {
				padding: 10px;
				margin: 0 5px;
				border: 1px solid black;
				color: black;
				}

				.pagination .page-numbers:hover {
				background-color: black;
				color: white;
				}

				.pagination .current {
				background-color: black;
				color: white;
				border: none;
				}

				@media (max-width: 668px){
					.wishes .wish{
						padding: 20px 40px;   
					}
					.wishes .wish .left{
						width: 80px;
						height: 80px;  
					}
				}
				@media (max-width: 468px){
					.wishes .wish{
						padding: 20px 20px;   
					}
					.wishes .wish .left{
						width: 60px;
						height: 60px;  
						gap: 40px;
					}
				}
			</style>
			<div class="wishes">
				<?php
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$the_query = new WP_Query( 
					array( 
						'posts_per_page' => $settings['post_per_page'], 
						'post_type' => 'wishes_submission',
						'paged' => $paged
					) 
				);
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div class="wish">
							<div class="left">
								<?php 
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( array( 80, 80 ) ); 
								}else{
									?>
									<img width="80" height="80" src="<?php echo \Elementor\Utils::get_placeholder_image_src(); ?>" alt="placeholder image of user">
									<?php
								}
								?>
							</div>
							<div class="right">
								<p>
									<?php echo get_the_content(); ?>
								</p>
								<span class="user">
									<?php echo 'From ' . get_the_title(); ?>
								</span>
							</div>
						</div>
					<?php endwhile; ?>
					<div class="pagination">
						<?php echo paginate_links( array( 'total' => $the_query->max_num_pages ) ); ?>
					</div>
					<?php wp_reset_postdata();
				else :
					echo '<p>No wishes found.</p>';
				endif; ?>
			</div>
			<?php
		}
	}


}