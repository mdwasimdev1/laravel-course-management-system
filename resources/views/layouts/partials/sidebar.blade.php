<div class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 " aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('course.create') }}" class="flex items-center p-2 text-lg font-medium text-gray-900 rounded-md hover:bg-gray-100  group {{ request()->routeIs('course.create') ? 'bg-gray-100 ' : '' }}">
                    <svg aria-hidden="true" class="flex w-6 h-6 text-gray-500 transition duration-75 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Create Course</span>
                </a>
            </li>
        </ul>
    </div>
</div>
