<!-- COMPONENT: ADD/EDIT FORM -->
<div id="form-container" class="bg-white mb-6 border-2 border-dashed border-blue-600 rounded-lg shadow-sm overflow-hidden text-sm transition-colors duration-300">
    <div id="form-header-div" class="bg-gray-100 px-4 py-2 font-bold flex justify-between items-center text-base transition-colors duration-300">
        <div class="flex items-center">
            <span id="form-icon" class="bg-blue-600 text-white rounded-full w-7 h-7 flex items-center justify-center mr-3 transition-colors duration-300">
                +
            </span> 
            <span id="form-title">Add New Company</span>
        </div>
        <a href="#" id="btn-cancel" class="hidden text-sm font-normal text-gray-600 underline hover:text-gray-900">Cancel Edit</a>
    </div>
    
    <div class="p-4">
        <form id="company-form">
            <input type="hidden" id="edit-id">
            
            <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-center">
                <div class="font-semibold">Name of company</div>
                <div><input type="text" id="company_name" class="w-full py-1 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none" required></div>
            </div>

            <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-start">
                <div class="font-semibold pt-1">Nature of company</div>
                <div class="flex flex-wrap gap-x-4 gap-y-1 pt-1">
                    <label class="flex items-center"><input type="radio" name="company_nature" value="Government" required class="mr-1"> Government</label>
                    <label class="flex items-center"><input type="radio" name="company_nature" value="Private" class="mr-1"> Private</label>
                    <label class="flex items-center"><input type="radio" name="company_nature" value="Multinational" class="mr-1"> Multinational</label>
                    <label class="flex items-center"><input type="radio" name="company_nature" value="Others" class="mr-1"> Others</label>
                </div>
            </div>

            <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-start">
                <div class="font-semibold pt-1">Address of company</div>
                <div><textarea id="company_address" class="w-full py-1 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none" rows="2" required></textarea></div>
            </div>

            <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-start">
                <div class="font-semibold pt-1">Core business</div>
                <div><textarea id="core_business" class="w-full py-1 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 outline-none" rows="2" required></textarea></div>
            </div>

            <div class="md:grid md:grid-cols-[200px_1fr] gap-2 mb-2 items-center bg-gray-100 px-3 py-2 rounded">
                <div class="font-semibold leading-tight">Supervisor’s Approval</div>
                <div class="flex flex-wrap gap-x-4 gap-y-1">
                    <input type="hidden" id="supervisor_approval" value="Pending">
                    
                    <label class="text-gray-500 flex items-center"><input type="radio" disabled name="display_supervisor_approval" value="Highly Recommended" class="mr-1"> Highly Recommended</label>
                    <label class="text-gray-500 flex items-center"><input type="radio" disabled name="display_supervisor_approval" value="Recommended" class="mr-1"> Recommended</label>
                    <label class="text-gray-500 flex items-center"><input type="radio" disabled name="display_supervisor_approval" value="Not Recommended" class="mr-1"> Not Recommended</label>
                    <label class="text-gray-500 flex items-center"><input type="radio" disabled name="display_supervisor_approval" value="Pending" checked class="mr-1"> <i>Pending</i></label>
                </div>
            </div>

            <div class="mt-3 text-right">
                <button type="submit" id="btn-submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-6 rounded transition text-sm">
                    Add New Choice
                </button>
            </div>
        </form>
    </div>
</div>
