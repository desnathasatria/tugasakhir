$('.filter-button').on('click', (e) => {
    const filter = $(e.target).attr('data-filter');
    console.log(filter);
       const items = $('.item-content').parent();
    for (item of items) {
      if (filter == '') {
        
          $(item).addClass('animated zoomIn faster');
        $(item).parent().addClass('animated zoomIn faster');
        $(item).removeClass('d-none');
        $(item).parent().removeClass('d-none');
        
       
        console.log('x');
      }else if ($(item).attr('data-category') == filter) {
        $(item).addClass('animated zoomIn faster');
        $(item).parent().addClass('animated zoomIn faster');
        $(item).removeClass('d-none');
        $(item).parent().removeClass('d-none');
      } else {
        $(item).addClass('d-none');
        $(item).parent().addClass('d-none');
        $(item).removeClass('animated zoomIn faster');
        $(item).parent().removeClass('animated zoomIn faster');
      }
    }
  });