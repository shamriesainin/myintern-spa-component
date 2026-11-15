document.addEventListener('DOMContentLoaded', () => {
    
    const showToast = (message) => {
        const toast = document.getElementById('toast');
        toast.querySelector('span').textContent = message;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    };

    const loadCompanies = async () => {
        try {
            const response = await fetch('api/api.php');
            const companies = await response.json();
            const listDiv = document.getElementById('company-list');
            
            if (companies.length === 0) {
                listDiv.innerHTML = '<p class="text-gray-600 italic text-sm">No companies added yet.</p>';
                return;
            }

            let html = '';
            companies.forEach(company => {
                const companyData = encodeURIComponent(JSON.stringify(company));
                const statusColor = company.supervisor_approval === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-200 text-gray-800';
                
                html += `
                <div class="bg-white border border-gray-200 rounded shadow-sm flex flex-col sm:flex-row overflow-hidden hover:bg-gray-50 transition">
                    
                    <div class="bg-blue-100 text-blue-800 w-full sm:w-12 flex items-center justify-center font-bold text-lg border-b sm:border-b-0 sm:border-r border-gray-200 py-1 sm:py-0">
                        ${company.choice_number}
                    </div>
                    
                    <div class="p-2.5 flex-1 text-sm">
                        <div class="font-bold text-base text-gray-900 leading-tight">
                            ${company.company_name} 
                            <span class="text-xs font-normal text-gray-500 bg-gray-200 px-1.5 py-0.5 rounded ml-1 align-middle">${company.company_nature}</span>
                        </div>
                        <div class="mt-1 text-gray-700 leading-snug"><span class="font-semibold">Core Business:</span> ${company.core_business}</div>
                        <div class="text-gray-700 leading-snug"><span class="font-semibold">Address:</span> ${company.company_address}</div>
                        
                        <div class="mt-1.5 flex items-center gap-2">
                            <span class="font-semibold text-gray-700 text-xs">Approval:</span> 
                            <span class="px-1.5 py-0.5 rounded text-[11px] font-semibold uppercase tracking-wider ${statusColor}">
                                ${company.supervisor_approval}
                            </span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-100 border-t sm:border-t-0 sm:border-l border-gray-200 p-2 flex sm:flex-col justify-center gap-1.5 min-w-[80px]">
                        <button onclick="editCompany('${companyData}')" type="button" class="bg-blue-500 text-white text-center w-full px-2 py-1 rounded text-xs font-bold hover:bg-blue-600 transition">Edit</button>
                        <button onclick="deleteCompany(${company.id})" type="button" class="bg-red-500 text-white w-full px-2 py-1 rounded text-xs font-bold hover:bg-red-600 transition">Delete</button>
                    </div>
                    
                </div>`;
            });
            listDiv.innerHTML = html;
        } catch (error) {
            console.error("Error loading data:", error);
        }
    };

    document.getElementById('company-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const editId = document.getElementById('edit-id').value;
        const formData = {
            company_name: document.getElementById('company_name').value,
            company_nature: document.querySelector('input[name="company_nature"]:checked').value,
            company_address: document.getElementById('company_address').value,
            core_business: document.getElementById('core_business').value,
            supervisor_approval: document.getElementById('supervisor_approval').value
        };

        const method = editId ? 'PUT' : 'POST';
        const url = editId ? `api/api.php?id=${editId}` : 'api/api.php';

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            showToast(result.message);
            resetForm();
            loadCompanies();
        } catch (error) {
            console.error("Error saving data:", error);
        }
    });

    window.editCompany = (encodedData) => {
        const company = JSON.parse(decodeURIComponent(encodedData));
        
        document.getElementById('edit-id').value = company.id;
        document.getElementById('company_name').value = company.company_name;
        document.getElementById('company_address').value = company.company_address;
        document.getElementById('core_business').value = company.core_business;
        document.getElementById('supervisor_approval').value = company.supervisor_approval;
        document.querySelector(`input[name="company_nature"][value="${company.company_nature}"]`).checked = true;
        
        const approvalRadios = document.querySelectorAll('input[name="display_supervisor_approval"]');
        approvalRadios.forEach(radio => {
            radio.checked = (radio.value === company.supervisor_approval);
        });

        const formContainer = document.getElementById('form-container');
        formContainer.classList.remove('border-dashed', 'border-blue-600');
        formContainer.classList.add('border-yellow-500');
        
        const headerDiv = document.getElementById('form-header-div');
        headerDiv.classList.remove('bg-gray-100');
        headerDiv.classList.add('bg-yellow-100');
        
        const iconSpan = document.getElementById('form-icon');
        iconSpan.classList.remove('bg-blue-600');
        iconSpan.classList.add('bg-yellow-500');
        iconSpan.textContent = company.choice_number;
        
        document.getElementById('form-title').textContent = 'Edit Company Choice';
        document.getElementById('btn-cancel').classList.remove('hidden');
        
        const btnSubmit = document.getElementById('btn-submit');
        btnSubmit.textContent = 'Update Choice';
        btnSubmit.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        btnSubmit.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    document.getElementById('btn-cancel').addEventListener('click', (e) => {
        e.preventDefault();
        resetForm(); 
    });

    const resetForm = () => {
        document.getElementById('company-form').reset();
        document.getElementById('edit-id').value = '';
        document.getElementById('supervisor_approval').value = 'Pending';
        
        document.querySelector('input[name="display_supervisor_approval"][value="Pending"]').checked = true;

        const formContainer = document.getElementById('form-container');
        formContainer.classList.remove('border-yellow-500');
        formContainer.classList.add('border-dashed', 'border-blue-600');
        
        const headerDiv = document.getElementById('form-header-div');
        headerDiv.classList.remove('bg-yellow-100');
        headerDiv.classList.add('bg-gray-100');
        
        const iconSpan = document.getElementById('form-icon');
        iconSpan.classList.remove('bg-yellow-500');
        iconSpan.classList.add('bg-blue-600');
        iconSpan.textContent = '+';
        
        document.getElementById('form-title').textContent = 'Add New Company';
        document.getElementById('btn-cancel').classList.add('hidden');
        
        const btnSubmit = document.getElementById('btn-submit');
        btnSubmit.textContent = 'Add New Choice';
        btnSubmit.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
        btnSubmit.classList.add('bg-blue-600', 'hover:bg-blue-700');
    };

    window.deleteCompany = async (id) => {
        if (confirm('Delete this choice?')) {
            try {
                const response = await fetch(`api/api.php?id=${id}`, { method: 'DELETE' });
                const result = await response.json();
                showToast(result.message);
                loadCompanies();
            } catch (error) {
                console.error("Error deleting data:", error);
            }
        }
    };

    loadCompanies();
});
