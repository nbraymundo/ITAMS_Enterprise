/*
|--------------------------------------------------------------------------
| ITAMS Enterprise Application JavaScript
|--------------------------------------------------------------------------
| Sidebar collapse / expand
| Mobile sidebar handling
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    const body = document.body;

    const sidebarToggle =
        document.getElementById('itamsSidebarToggle');


    /*
    |--------------------------------------------------------------------------
    | Sidebar Toggle
    |--------------------------------------------------------------------------
    */

    if (!sidebarToggle) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Restore Saved Desktop Sidebar State
    |--------------------------------------------------------------------------
    */

    const savedState =
        localStorage.getItem(
            'itamsSidebarCollapsed'
        );


    if (
        window.innerWidth > 991 &&
        savedState === 'true'
    ) {

        body.classList.add(
            'sidebar-collapsed'
        );

        sidebarToggle.setAttribute(
            'aria-expanded',
            'false'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Toggle Sidebar
    |--------------------------------------------------------------------------
    */

    sidebarToggle.addEventListener(
        'click',
        function () {


            /*
            |--------------------------------------------------------------------------
            | Mobile
            |--------------------------------------------------------------------------
            */

            if (window.innerWidth <= 991) {

                body.classList.toggle(
                    'sidebar-mobile-open'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Desktop
            |--------------------------------------------------------------------------
            */

            body.classList.toggle(
                'sidebar-collapsed'
            );


            const isCollapsed =
                body.classList.contains(
                    'sidebar-collapsed'
                );


            /*
            |--------------------------------------------------------------------------
            | Remember User Preference
            |--------------------------------------------------------------------------
            */

            localStorage.setItem(
                'itamsSidebarCollapsed',
                isCollapsed
                    ? 'true'
                    : 'false'
            );


            /*
            |--------------------------------------------------------------------------
            | Accessibility
            |--------------------------------------------------------------------------
            */

            sidebarToggle.setAttribute(
                'aria-expanded',
                isCollapsed
                    ? 'false'
                    : 'true'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Close Mobile Sidebar When Clicking Outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (window.innerWidth > 991) {
                return;
            }


            if (
                !body.classList.contains(
                    'sidebar-mobile-open'
                )
            ) {
                return;
            }


            const sidebar =
                document.querySelector(
                    '.sidebar'
                );


            if (!sidebar) {
                return;
            }


            const clickedInsideSidebar =
                sidebar.contains(
                    event.target
                );


            const clickedToggle =
                sidebarToggle.contains(
                    event.target
                );


            if (
                !clickedInsideSidebar &&
                !clickedToggle
            ) {

                body.classList.remove(
                    'sidebar-mobile-open'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Close Mobile Sidebar After Navigation
    |--------------------------------------------------------------------------
    */

    const sidebarLinks =
        document.querySelectorAll(
            '.sidebar a'
        );


    sidebarLinks.forEach(
        function (link) {

            link.addEventListener(
                'click',
                function () {

                    if (
                        window.innerWidth <= 991
                    ) {

                        body.classList.remove(
                            'sidebar-mobile-open'
                        );

                    }

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Handle Window Resize
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'resize',
        function () {

            /*
             * Returning to desktop
             */

            if (window.innerWidth > 991) {

                body.classList.remove(
                    'sidebar-mobile-open'
                );


                const savedState =
                    localStorage.getItem(
                        'itamsSidebarCollapsed'
                    );


                if (
                    savedState === 'true'
                ) {

                    body.classList.add(
                        'sidebar-collapsed'
                    );

                    sidebarToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                } else {

                    body.classList.remove(
                        'sidebar-collapsed'
                    );

                    sidebarToggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                }

            }

        }
    );

});