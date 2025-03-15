<script lang="ts">
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, defineComponent } from 'vue';

export default defineComponent({
  name: 'MainHeader',
  methods: {
    router() {
      return router;
    },
  },
  components: { ApplicationLogo, Dropdown, DropdownLink, Link },
  data: () => ({
    items: [
      {
        name: 'Estate',
        link: route('estate.index'),
      },
      {
        name: 'About',
        link: '/about',
      },
      {
        name: 'Services',
        link: '/services',
      },
      {
        name: 'Contact Us',
        link: '/contact-us',
      },
    ],
  }),
  setup() {
    const page = usePage();

    return {
      user: computed(() => page.props.auth.user),
    };
  },
});
</script>

<template>
  <div
    class="w-full border-slate-50/40 border-b bg-cover bg-[url('https://ssl.cdn-redfin.com/v525.2.0/images/homepage/banners/genHomepageDesktopBanner/HPTO_2120-NW-97th-St-Seattle_PremierHP.jpg')]"
  >
    <div class="backdrop-blur-sm bg-black/1 5">
      <div class="max-w-7xl mx-auto flex gap-6 py-4">
        <ApplicationLogo
          class="cursor-pointer"
          v-on:click="router().visit(route('home'))"
        />
        <template v-for="(item, index) in items">
          <Link
            :class="{ 'border-r': index !== items.length - 1 }"
            :href="item.link"
            class="px-6 px-2 cursor-pointer text-white hover:text-gray-200 border-b-4 border-b-transparent border-t-4 border-t-transparent my-auto font-medium text-sm"
          >
            {{ item.name }}
          </Link>
        </template>

        <Link
          v-if="!user"
          :href="route('login')"
          class="ml-auto px-6 my-auto cursor-pointer text-white hover:text-gray-200"
        >
          Login
        </Link>
        <div v-else class="ml-auto hidden sm:block">
          <Dropdown align="right" width="48">
            <template #trigger>
              <span class="">
                <button
                  class="text-white inline-flex items-center px-3 py-2 leading-4 font-medium rounded-md hover:text-gray-200 focus:outline-none transition ease-in-out duration-150 text-sm"
                  type="button"
                >
                  {{ $page.props.auth.user.name }}

                  <svg
                    class="ms-2 -me-0.5 h-4 w-4"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      clip-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      fill-rule="evenodd"
                    />
                  </svg>
                </button>
              </span>
            </template>

            <template #content>
              <DropdownLink :href="route('dashboard.index')"
                >Dashboard</DropdownLink
              >
              <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
              <DropdownLink :href="route('logout')" as="button" method="post"
                >Log Out</DropdownLink
              >
            </template>
          </Dropdown>
        </div>
      </div>
    </div>
  </div>
</template>
