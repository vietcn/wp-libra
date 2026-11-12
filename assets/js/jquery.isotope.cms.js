(function($){
    $(document).ready(function(){
      var $container = $('.cms-blog-masonry');
      $('.cms-blog-masonry').each(function(){
     		$this = $(this);
        $filter = $this.parent().find('.cms-grid-filter');
     		$this.imagesLoaded(function(){
     			$this.isotope({
	           itemSelector:'.cms-blog-masonry-item',
	        });
     		});
        $filter.find('a').click(function(e){
            e.preventDefault();
            $filter.find("a").removeClass('active');
            $(this).addClass('active');
            var data_filter = $(this).data('filter');
            $this.isotope({
                filter: data_filter
            });
        });
      });
    });
})(jQuery);