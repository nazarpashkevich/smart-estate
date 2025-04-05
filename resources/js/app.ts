import '../css/app.css';
import './bootstrap';

import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, DirectiveBinding, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

interface HTMLElementWithClickOutside extends HTMLElement {
  clickOutsideEvent?: (event: Event) => void;
}

// action for click outside
const clickOutside = {
  beforeMount: (el: HTMLElement, binding: DirectiveBinding) => {
    const element = el as HTMLElementWithClickOutside;

    element.clickOutsideEvent = (event: Event) => {
      if (
        !(
          element === event.target ||
          (event.target instanceof Node && element.contains(event.target))
        )
      ) {
        // if it did, call method provided in directive value
        binding.value();
      }
    };

    document.addEventListener('click', element.clickOutsideEvent);
  },
  unmounted: (el: HTMLElement) => {
    const element = el as HTMLElementWithClickOutside;

    if (element.clickOutsideEvent) {
      document.removeEventListener('click', element.clickOutsideEvent);
    }
  },
};

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./pages/**/*.vue'),
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('Link', Link)
      .directive('click-outside', clickOutside)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
