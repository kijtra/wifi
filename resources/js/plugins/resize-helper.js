import Vue from 'vue'

const onWindowResizeHelper = {
  install(Vue) {
    if (!Vue.prototype.$helper) {
      Vue.prototype.$helper = {}
    }

    Vue.prototype.$helper.onWindowResize = (callback, delay, once) => {
      if ('function' !== typeof callback) {
          return;
      }

      let resizeTimer, resized = e => {
          if (delay) {
              if (resizeTimer) {
                  clearTimeout(resizeTimer);
              }
              resizeTimer = setTimeout(() => {
                  callback(e);
              }, delay);
          } else {
              callback(e);
          }

          if (once) {
              window.removeEventListener('resize', resized);
          }
      };
      window.addEventListener('resize', resized);
    }
  }
}

Vue.use(onWindowResizeHelper)
