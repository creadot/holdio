// jQuery(document).ready(function() {
//   var scrollOffset = 70;
//   var scrollDuration = 800;
  
//   var lastClickedHash = '';
  
//   jQuery('a[href*="#"]:not([href="#"])').click(function(e){
//     var href = this.getAttribute('href');
//     var currentPath = window.location.pathname;
    
//     // Parse the URL to determine if it's pointing to a different page
//     var isExternalLink = false;
    
//     if (href.indexOf('/') === 0) {
//       // This is an absolute path
//       var hrefPath = href.split('#')[0];
//       // If paths don't match and href isn't just a hash, it's external
//       isExternalLink = hrefPath !== '' && currentPath !== hrefPath;
//     }
    
//     if (isExternalLink) {
//       // This link points to a different page - let default navigation happen
//       return true;
//     } else {
//       // This is an in-page anchor - handle with smooth scroll
//       e.preventDefault();
      
//       // Extract the hash part
//       var _hash = href.indexOf('#') !== -1 ? '#' + href.split('#')[1] : href;
      
//       if (history.pushState) {
//         history.pushState(null, null, _hash);
//       } else {
//         location.hash = _hash;
//       }
      
//       lastClickedHash = _hash;
//       scrollWithRetry(_hash);
//       return false;
//     }
//   });
  
//   var _hash = window.location.hash;
//   if(_hash.length > 0) {     
//     window.scrollTo(0, 0);
    
//     setTimeout(function() { 
//       scrollWithRetry(_hash);
//     }, 800);       
//   }
  
//   function scrollWithRetry(_hash) {
//     simpleScrollTo(_hash);
    
//     setTimeout(function() {
//       simpleScrollTo(_hash);
      
//       setTimeout(function() {
//         simpleScrollTo(_hash);
//       }, 500);
//     }, 200);
//   }
  
//   function simpleScrollTo(_hash) {
//     jQuery('html, body').stop(true);
    
//     var $target = jQuery(_hash);
//     if ($target.length === 0) return;
    
//     var targetOffset = $target.offset().top;
//     var adjustedOffset = scrollOffset;
    
//     if ($target.hasClass('mix') || $target.attr('id') === 'mixitup-services' || 
//         $target.closest('.mix').length > 0) {
//       adjustedOffset = scrollOffset + 10;
//     }
    
//     jQuery('html, body').animate({
//       scrollTop: targetOffset - adjustedOffset
//     }, scrollDuration);
//   }
// });





















jQuery(document).ready(function() {
  var scrollOffset = 70;
  var scrollDuration = 800;
  
  var lastClickedHash = '';
  
  setTimeout(function() {
    jQuery('body').css({
      'opacity': '1',
      'transition': 'opacity 0.5s ease-in-out'
    });
  }, 1000);
  
  function showLoading() {
    jQuery('.loading').addClass('loading--visible');
    var loadingElement = jQuery('.loading')[0];
    if (loadingElement) {
      loadingElement.dataset.showTime = Date.now();
    }
  }
  
  function hideLoading() {
    jQuery('.loading').removeClass('loading--visible');
  }
  
  function instantScrollTo(_hash, hideLoadingAfter = false) {
    var $target = jQuery(_hash);
    if ($target.length === 0) {
      if (hideLoadingAfter) hideLoading();
      return;
    }
    
    var targetOffset = $target.offset().top;
    var adjustedOffset = scrollOffset;
    
    if ($target.hasClass('mix') || $target.attr('id') === 'mixitup-services' || 
        $target.closest('.mix').length > 0) {
      adjustedOffset = scrollOffset + 10;
    }
    
    jQuery('html, body').stop(true).scrollTop(targetOffset - adjustedOffset);
    
    if (hideLoadingAfter) {
      setTimeout(hideLoading, 100);
    }
  }
  
  function instantScrollWithRetry(_hash) {
    instantScrollTo(_hash);
    
    setTimeout(function() {
      instantScrollTo(_hash);
      
      setTimeout(function() {
        instantScrollTo(_hash, true);
      }, 50);
    }, 50);
  }
  
  function simpleScrollTo(_hash) {
    jQuery('html, body').stop(true);
    
    var $target = jQuery(_hash);
    if ($target.length === 0) return;
    
    var targetOffset = $target.offset().top;
    var adjustedOffset = scrollOffset;
    
    if ($target.hasClass('mix') || $target.attr('id') === 'mixitup-services' || 
        $target.closest('.mix').length > 0) {
      adjustedOffset = scrollOffset + 10;
    }
    
    jQuery('html, body').animate({
      scrollTop: targetOffset - adjustedOffset
    }, scrollDuration);
  }
  
  function scrollWithRetry(_hash) {
    simpleScrollTo(_hash);
    
    setTimeout(function() {
      simpleScrollTo(_hash);
      
      setTimeout(function() {
        simpleScrollTo(_hash);
      }, 500);
    }, 200);
  }
  
  jQuery('.header a[href*="#"]:not([href="#"])').click(function(e){
    e.preventDefault();
    
    var href = this.getAttribute('href');
    var currentPath = window.location.pathname;
    
    var isExternalLink = false;
    var hrefPath = '';
    
    if (href.indexOf('http') === 0) {
      try {
        var url = new URL(href);
        hrefPath = url.pathname;
      } catch (e) {
        hrefPath = href.split('#')[0];
      }
    } else if (href.startsWith('/#')) {
      hrefPath = '/';
    } else if (href.indexOf('/') === 0) {
      hrefPath = href.split('#')[0];
    } else {
      hrefPath = currentPath;
    }
    
    if (href.indexOf('#') === 0) {
      isExternalLink = false;
    } else {
      isExternalLink = currentPath !== hrefPath;
    }
    
    if (isExternalLink) {
      window.location.href = href;
      return;
    }
    
    showLoading();
    
    var _hash = href.indexOf('#') !== -1 ? '#' + href.split('#')[1] : href;
    
    hideLoading();
    setTimeout(function() {
      showLoading();
      
      if (history.pushState) {
        history.pushState(null, null, _hash);
      } else {
        location.hash = _hash;
      }
      
      lastClickedHash = _hash;
      
      setTimeout(function() {
        instantScrollWithRetry(_hash);
      }, 100);
      
    }, 50);
  });
  
  jQuery('a[href*="#"]:not([href="#"]):not(.header a)').click(function(e){
    var href = this.getAttribute('href');
    var currentPath = window.location.pathname;
    
    var isExternalLink = false;
    
    if (href.startsWith('/#')) {
      isExternalLink = currentPath !== '/';
    } else if (href.indexOf('/') === 0 && href.indexOf('#') > 0) {
      var hrefPath = href.split('#')[0];
      isExternalLink = currentPath !== hrefPath;
    }
    
    if (isExternalLink) {
      return true;
    } else {
      e.preventDefault();
      
      var _hash = href.indexOf('#') !== -1 ? '#' + href.split('#')[1] : href;
      
      if (history.pushState) {
        history.pushState(null, null, _hash);
      } else {
        location.hash = _hash;
      }
      
      lastClickedHash = _hash;
      scrollWithRetry(_hash);
      
      return false;
    }
  });
  
  var _hash = window.location.hash;
  if(_hash.length > 0) {     
    window.scrollTo(0, 0);
    showLoading();
    
    setTimeout(function() { 
      instantScrollWithRetry(_hash);
    }, 1200);
  }
  
  jQuery(window).on('hashchange', function() {
    var newHash = window.location.hash;
    if (newHash && newHash.length > 1 && newHash !== lastClickedHash) {
      showLoading();
      setTimeout(function() {
        instantScrollWithRetry(newHash);
      }, 150);
    }
    lastClickedHash = newHash;
  });
  
  setInterval(function() {
    if (jQuery('.loading').hasClass('loading--visible')) {
      var loadingElement = jQuery('.loading')[0];
      if (loadingElement && loadingElement.dataset.showTime) {
        var loadingTime = Date.now() - parseInt(loadingElement.dataset.showTime);
        if (loadingTime > 10000) {
          hideLoading();
        }
      }
    }
  }, 1000);
});