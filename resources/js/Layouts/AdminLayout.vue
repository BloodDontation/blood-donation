<template>

    <div class="flex h-screen" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <!-- Desktop sidebar -->

        <aside class="z-20 hidden w-64 overflow-y-auto md:block flex-shrink-0 shadow-md"
            v-show="isSideDesktopMenuOpen">
            <div class="py-4 ">

                <div class="flex w-full shadow-lg pb-5">
                    <inertia-link class="ml-6 text-lg font-bold" :href="route('admin-dashboard')">
                        {{trans('blood-dontation-session')}}
                    </inertia-link>
                </div>

                <ul class="menu mt-5 ">

                    <template v-for="(nav_item, key, index) in nav_items" :key="index">

                        <li v-if="nav_item.permission"
                            :class="[ index == active_index ? 'bordered' : 'hover-bordered' ]"
                        >

                            <template v-if="nav_item.childs.length == 0">

                                <a :href="nav_item.route ? route(nav_item.route) : ''">

                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 mr-2 stroke-current">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg> -->
                                    <li :class="nav_item.icon"
                                        style="border-left-width:0"></li>

                                    <span class="ml-4" style="border-left-width:0">
                                        {{trans(key)}}
                                    </span>

                                </a>

                            </template>

                            <template v-else>

                                <a @click.prevent="toggleNavItemMenu(index)">

                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 mr-2 stroke-current">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg> -->
                                    <li :class="nav_item.icon"
                                        style="border-left-width:0"></li>

                                    <div class="flex w-full justify-between">

                                        <span class="ml-4" style="border-left-width:0">
                                            {{trans(key)}}
                                        </span>

                                        <svg class="w-4 h-4 my-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>

                                    </div>

                                </a>

                                <transition enter-active-class="transition ease-out duration-200"
                                    enter-from-class="transform translat-y-0 scale-95"
                                    enter-to-class="transform translate-y-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">

                                    <template v-if="is_nav_item_childs_open(index)">

                                        <ul class="menu">

                                            <template v-for="(child_nav_item, child_nav_key) in nav_item.childs"
                                                :key="child_nav_item.title">

                                                <li>
                                                    <a :href="route(child_nav_item.route)"
                                                    style="border-left-width:0">

                                                        <span class="ml-4" style="border-left-width:0">
                                                            {{trans(child_nav_key)}}
                                                        </span>

                                                    </a>

                                                </li>

                                            </template>


                                        </ul>

                                    </template>

                                </transition>



                            </template>


                        </li>

                    </template>


                </ul>


            </div>
            <!-- <span class="mb-2 ml-6 bottom-0 absolute text-sm font-extralight  " :href="route('accounting-landlord-admin-dashboard')">
                {{trans('powered-by')}} {{current_version}}
            </span> -->
        </aside>
        <!-- end Desktop sidebar -->

        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <div v-show="isSideMenuOpen" @click="toggleSideMenu"
            class="fixed inset-0 z-10 flex items-end bg-black  sm:items-center sm:justify-center"></div>

        <!-- mobile sidebar -->
        <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto md:hidden"
            v-show="isSideMenuOpen" @click.self="toggleSideMenu">
            <div class="py-4 ">
                <a class="ml-6 text-lg font-bold " href="#">
                    Elya Store
                </a>

                <ul class="mt-6">

                    <template v-for="(nav_item, key, index) in nav_items" :key="index">

                        <li class="relative px-6 py-3">

                            <template v-if="nav_item.childs.length == 0">

                                <span class="absolute inset-y-0 left-0 w-1  rounded-tr-lg rounded-br-lg"
                                    aria-hidden="true" v-if="index == active_index"></span>
                                <InertiaLink
                                    class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover: "
                                    :href="nav_item.route ? route(nav_item.route) : ''">
                                    <!--  -->
                                    <span v-html="nav_item.icon"></span>
                                    <span class="ml-4">
                                        {{nav_item.title}}
                                    </span>
                                </InertiaLink>

                            </template>

                            <template v-else>

                                <button
                                    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover: "
                                    @click="toggleNavItemMenu(index)" aria-haspopup="true">

                                    <span class="inline-flex items-center">
                                        <span v-html="nav_item.icon"></span>
                                        <span class="ml-4">
                                            <span
                                                class="absolute inset-y-0 left-0 w-1  rounded-tr-lg rounded-br-lg"
                                                aria-hidden="true" v-if="index == active_index"></span>
                                            {{nav_item.title}}
                                        </span>
                                    </span>
                                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                <transition enter-active-class="transition ease-out duration-200"
                                    enter-from-class="transform translat-y-0 scale-95"
                                    enter-to-class="transform translate-y-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">


                                    <template v-if="is_nav_item_childs_open(index)">
                                        <ul class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium rounded-md shadow-inner  "
                                            aria-label="submenu">

                                            <template v-for="child_nav_item in nav_item.childs"
                                                :key="child_nav_item.title">

                                                <li class="px-2 py-1 transition-colors duration-150 hover:"
                                                    v-if="child_nav_item.permission">

                                                    <InertiaLink class="w-full" :href="route(child_nav_item.route)">

                                                        {{child_nav_item.title}}
                                                    </InertiaLink>

                                                </li>

                                            </template>

                                        </ul>
                                    </template>
                                </transition>


                            </template>

                        </li>



                    </template>


                    <!-- <li class="relative px-6 py-3">
                        <button
                            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover: dark:hover:"
                            @click="togglePagesMenu" aria-haspopup="true">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                    </path>
                                </svg>
                                <span class="ml-4">Pages</span>
                            </span>
                            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <template v-if="isPagesMenuOpen">
                            <ul class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium  rounded-md shadow-inner  dark: dark:"
                                aria-label="submenu">
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover: dark:hover:">
                                    <a class="w-full" href="pages/login.html">Login</a>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover: dark:hover:">
                                    <a class="w-full" href="pages/create-account.html">
                                        Create account
                                    </a>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover: dark:hover:">
                                    <a class="w-full" href="pages/forgot-password.html">
                                        Forgot password
                                    </a>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover: dark:hover:">
                                    <a class="w-full" href="pages/404.html">404</a>
                                </li>
                                <li
                                    class="px-2 py-1 transition-colors duration-150 hover: dark:hover:">
                                    <a class="w-full" href="pages/blank.html">Blank</a>
                                </li>
                            </ul>
                        </template>
                    </li> -->
                </ul>
            </div>
        </aside>
        <!-- end mobile sidebard -->

        <div class="flex flex-col flex-1 w-full">
            <header class="z-10 py-4 shadow-md">
                <div class="flex items-center justify-between h-full px-6 mx-auto  dark:">
                    <!-- Mobile hamburger -->
                    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
                        @click="toggleSideMenu" aria-label="Menu">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <!-- end Mobile hamburger -->

                    <!-- desktop hamburger -->
                    <button class="p-1 mr-5 -ml-1 sm: hidden md:block focus:outline-none focus:shadow-outline-purple"
                        @click="toggleDesktopSideMenu" aria-label="Menu">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Search input -->
                    <!-- <div class="flex justify-center flex-1 lg:mr-32">
                        <div class="relative w-full max-w-xl mr-6 focus-within:">

                        </div>
                    </div> -->
                    <!-- end search input -->

                    <!-- Breadcrumb -->

                    <div class="text-sm breadcrumbs flex flex-1">

                        <ul>

                            <template v-for="page in breadcrumb" :key="page">

                                <li :class="(page.route || page.detail_link) ? 'flex items-center' : ''" class="whitespace-nowrap">

                                    <template v-if="page.route || page.detail_link">

                                        <a :href="page.detail_link  ? page.detail_link : route(page.route)">
                                            {{trans(page.name)}}
                                        </a>

                                    </template>

                                    <template v-else>

                                        <a href="#" class="text-gray-500 cursor-default" aria-current="page">
                                            {{trans(page.name)}}
                                        </a>

                                    </template>

                                </li>

                            </template>


                        </ul>

                    </div>

                    <!-- end Breadcrumb -->

                    <div tabindex="0" class="flex-none dropdown dropdown-end">
                        <div class="avatar" >
                            <div class="rounded-full w-10 h-10 m-1">

                                <img src="https://i.pravatar.cc/500?img=32">

                            </div>
                        </div>

                        <ul tabindex="0" class="shadow menu dropdown-content bg-base-100 rounded-box w-52">

                            <li v-for="(properties, local_code) in this.$page.props.lang['supported_languages']" :key="local_code">

                                <a @click="change_language_to(local_code)"
                                    :class="local_code == get_current_lang() ? 'active' : ''">

                                    <span>
                                        {{properties.key}}
                                    </span>

                                </a>

                            </li>

                        </ul>

                    </div>

                </div>

            </header>
            <main class="h-full overflow-y-auto bg-gray-100">

                <slot></slot>

            </main>
        </div>
    </div>

</template>

<script>


    export default {

        props: {

            user: Object,
            nav_items: [],
            active_index: 0,
            breadcrumb: [],

        },

        data: function()
        {

            return {

                isSideDesktopMenuOpen: true,

                isSideMenuOpen: false,

                isPagesMenuOpen: false,

                isProfileMenuOpen: false,

                isLanguageMenuOpen: false,

                navItemsOpenedChilds: [],

                duration: 0,

            };

        },

        updated()
        {

            // if ( this.$page.props.flash.toast )
            // {

            //     this.$moshaToast( this.trans( this.$page.props.flash?.toast?.message ) , {

            //         type: this.$page.props.flash?.toast?.status,
            //         showIcon: true,
            //         hideProgressBar: true,


            //     });

            // }

        },

        methods: {

            is_nav_item_childs_open(index) {

                return this.navItemsOpenedChilds.some(x => x === index);

            },

            toggleNavItemMenu(index) {

                if (this.is_nav_item_childs_open(index)) {
                    this.navItemsOpenedChilds.splice(this.navItemsOpenedChilds.findIndex(x => x === index), 1);
                    return;
                }
                this.navItemsOpenedChilds.push(index);

            },

            show_toast: function()
            {

                if ( this.$page.props?.flash?.toast )
                {

                    this.$moshaToast( this.trans( this.$page.props.flash?.toast?.message ) , {

                        type: this.$page.props.flash?.toast?.status,
                        showIcon: true,
                        hideProgressBar: true,


                    });

                }

            },

            change_language_to(language) {

                // let new_url = window.location.origin + window.location.pathname.replace('/en/', `/${language}/`)
                //     .replace('/ar/', `/${language}/`);

                // window.location.href = new_url;

                const old_language      = this.$page.props.lang.current_language;

                let new_url             = window.location.origin;

                if ( window.location.pathname.includes(`/${old_language}`) )
                {

                    new_url = window.location.pathname.replace(`/${old_language}`, `/${language}`);

                }
                else
                {

                    new_url = window.location.origin + `/${language}` + window.location.pathname;

                }



                window.location.href    = new_url;

            },

            logout: function()
            {
                this.$inertia.post(route('logout'));
            },

        },

    }

</script>
