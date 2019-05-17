function ready(fn) {
  if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

const f = (function(document, window, f) {
  const node = Node.prototype,
      nodeList = NodeList.prototype,
      elem = Element.prototype,
      forEach = 'forEach',
      trigger = 'trigger',
      each = [][forEach],
      // note: createElement requires a string in Firefox
      dummy = document.createElement('i');

  nodeList[forEach] = each;

  elem.toggleClass = function(className) {
    const el = this;
    if (el.classList) {
      el.classList.toggle(className);
    } else {
      const classes = el.className.split(' ');
      const existingIndex = classes.indexOf(className);

      if (existingIndex >= 0)
        classes.splice(existingIndex, 1);
      else
        classes.push(className);

      el.className = classes.join(' ');
    }
  }

  elem.removeClass = function(className) {
    const el = this;
    if (el.classList)
      el.classList.remove(className);
    else
      el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
  }

  elem.addClass = function(className) {
    const el = this;
    if (el.classList)
      el.classList.add(className);
    else
      el.className += ' ' + className;
  }

  elem.attr = function(attr, val) {
    if (!!val === false) {
      return this.getAttribute(attr);
    } else {
      this.setAttribute(attr, val);
    }
  }

  elem.data = function(name) {
    return this.getAttribute(`data-${name}`);
  }

  elem[forEach] = function(fn) {
    fn(this);
  }

  window.on = node.on = function (event, fn) {
    this.addEventListener(event, fn, false);

    // allow for chaining
    return this;
  };

  nodeList.on = function (event, fn) {
    this[forEach](function (el) {
      el.on(event, fn);
    });
    return this;
  };

  window[trigger] = node[trigger] = function (type, data) {
    // construct an HTML event. This could have
    // been a real custom event
    const event = document.createEvent('HTMLEvents');
    event.initEvent(type, true, true);
    event.data = data || {};
    event.eventName = type;
    event.target = this;
    this.dispatchEvent(event);
    return this;
  };

  nodeList[trigger] = function (event) {
    this[forEach](function (el) {
      el[trigger](event);
    });
    return this;
  };

  f = function (fn) {
    $doc = this === window ? document : this;
    const r = $doc.querySelectorAll(fn),
            length = r.length;
    return length == 1 ? r[0] : r;
  };

  elem.f = f;
  return f;

})(document, this);