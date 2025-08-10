// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
async function getData_Variabel() {
    // setLoadingData(true);
    try {
        const sort = document.getElementById('select-sort').value || 'variabel';
        console.info('sort',sort);

        const by = document.getElementById('select-by').value || 'asc';
        console.info('by',by);

        const currentpage = document.getElementById('select-page').value || 1;
        console.info('currentpage',currentpage);

        const toSearch = document.getElementById('txt-search').value || '-';
        console.info('toSearch',toSearch);

        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;
        const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
            withCredentials: true,  // Mengirimkan cookie dalam permintaan
        });
        const response = await axios.get(`/api/variabel-setting/${sort}/${by}/${toSearch}?page=${currentpage}`, {
            withCredentials: true,
            headers: {
                'Content-Type': 'application/json',
                'XSRF-TOKEN': csrfToken,
                'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                'tokenlogin': '{{ $unique; }}',
                'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                '--unique--': 'I am unique!',
                'isvalid': 'VALID!',
                'isallowed': true,
                'key': 'key',
                'values': 'values',
                'isdumb': 'no',
                'challenger': 'of course',
                'pranked': 'absolutely'
            }
        });
        const data = response.data.data.data;
        lastpage = response.data.data.last_page;
        console.info('response', response);
        // setData(response.data.data.data);
        // setLastpage(response.data.data.last_page);
        // console.log('response', response);

        const dataContainer = document.querySelector('#data-container');
        dataContainer.innerHTML = ''; // Clear existing content

        console.info('API Response:', data);
        if (Array.isArray(data)) {
            console.info('data exist!');
            data.forEach(item => {
                const div = document.createElement('div');
                // const id = `{{ myfunction::enval('${item.id}') }}`;
                // console.info('id', id);
                div.className = 'bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 border-black';
                div.innerHTML = `
                <div class="static">
                    <div>
                        <span onclick="toEdit(${item.id}, '${item.variabel}', ${item.values})">
                            ${item.variabel} = ${item.values}
                        </span>
                    </div>
                    <div class="text-right" style="margin-top: -23px;">
                        <span onclick="toEdit(${item.id}, '${item.variabel}', '${item.values}')" style="margin-right: 10px;">
                            <ion-icon name="pencil-outline"></ion-icon>
                            <span class="hidden">Edit</span>
                        </span>
                        <span onclick="fDelete(${item.id}, '${item.variabel}', '${item.values}')">
                            <ion-icon name="trash-outline"></ion-icon>
                            <span class="hidden">Delete</span>
                        </span>
                    </div>
                </div>
                `;
                dataContainer.appendChild(div);
            });
        } else {
            console.warn('Data is not an array:', data);
        }

        

        // lastPage = response.data.data.last_page;
    }
    catch(err) {
        console.info("Terjadi Error AdminVariabel-getData:", err);
    }
    // setLoadingData(false);
}

async function getData_AllPeserta(toSearch) {
    // setLoadingData(true);
    try {
        sort = document.getElementById('select-sort').value;
        by = document.getElementById('select-by').value;

        // const sort = document.getElementById('select-sort').value || 'variabel';
        // console.info('sort',sort);

        // const by = document.getElementById('select-by').value || 'asc';
        // console.info('by',by);

        // const currentpage = document.getElementById('select-page').value || 1;
        // console.info('currentpage',currentpage);

        // const toSearch = document.getElementById('txt-search').value || '-';
        // console.info('toSearch',toSearch);


        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;
        const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
            withCredentials: true
        });
        const response = await axios.get(`/api/peserta/${sort}/${by}/${toSearch}?page=${currentpage}`, {
            withCredentials: true,  // Mengirimkan cookie dalam permintaan
            headers: {
                'Content-Type': 'application/json',
                'XSRF-TOKEN': csrfToken,
                'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                'tokenlogin': '{{ $unique; }}',
                'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                '--unique--': 'I am unique!',
                'isvalid': 'VALID!',
                'isallowed': true,
                'key': 'key',
                'values': 'values',
                'isdumb': 'no',
                'challenger': 'of course',
                'pranked': 'absolutely'
            }
        });
        data = response.data.data.data;
        // setData(response.data.data.data);
        // setLastpage(response.data.data.last_page);
        // console.log('response', response);

        const dataContainer = document.querySelector('#data-container');
        dataContainer.innerHTML = '';

        console.info('API Response:', data);
        if (Array.isArray(data)) {
            console.info('data exist!');
            data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 text-black border-black';
                div.innerHTML = `
                <a href="/admin/peserta-detil/${item.id}" title="Detil Peserta ${item.nama}" rel="follow">
                    <h3>
                        <p><span class="font-bold">${item.nama}</span></p>
                        <p>${item.no_identitas}</p>
                        <p>${item.email}</p>
                        <p>${item.asal}</p>
                    </h3>
                </a>
                `;
                dataContainer.appendChild(div);
            });
        } else {
            console.warn('Data is not an array:', data);
        }
    }
    catch(err) {
        console.info('Error AdminPeserta-getData:', err);
    }
    // setLoadingData(false);
}

async function getData_PsikotestKecermatan() {
    // setLoading(true);
    try {
        const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
            withCredentials: true,  // Mengirimkan cookie dalam permintaan
        });
        const response = await axios.get(`/api/kecermatan-kolompertanyaan`, {
            withCredentials: true,  // Mengirimkan cookie dalam permintaan
            headers: {
                'Content-Type': 'application/json',
                'XSRF-TOKEN': csrfToken,
                'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                'tokenlogin': '{{ $unique; }}',
                'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                '--unique--': 'I am unique!',
                'isvalid': 'VALID!',
                'isallowed': true,
                'key': 'key',
                'values': 'values',
                'isdumb': 'no',
                'challenger': 'of course',
                'pranked': 'absolutely'
            }
        });
        console.info('response', response);
        // setData(response.data.data);

        const dataContainer = document.querySelector('#data-container');
        dataContainer.innerHTML = ''; // Clear existing content

        response.data.data.forEach(item => {
            const div = document.createElement('div');
            // console.info('id', id);
            div.className = 'bg-slate-50 border-b-2 p-3 rounded-t-md mt-2 text-black border-black';
            div.innerHTML = `
            <div class="static">
                <div>
                    <span onclick="onDetil(${item.id})">
                        ${item.kolom_x}
                    </span>
                </div>
                <div class="text-right" style="margin-top: -23px;">
                    <span onclick="toEdit(${item.id}, '${item.kolom_x}', '${item.nilai_A}', '${item.nilai_B}', '${item.nilai_C}', '${item.nilai_D}', '${item.nilai_E}')" style="margin-right: 10px;">
                        <ion-icon name="pencil-outline"></ion-icon>
                        <span class="hidden">Edit</span>
                    </span>
                    <span onclick="fDelete(${item.id}, '${item.kolom_x}')">
                        <ion-icon name="trash-outline"></ion-icon>
                        <span class="hidden">Delete</span>
                    </span>
                </div>
            </div>
            `;
            dataContainer.appendChild(div);
        });
    } catch (err) {
        console.info('Terjadi Error PsikotestKecermatan-getData', err);
    }
    // setLoading(false);
}

async function getData_PsikotestKecermatanDetil() {
    // setLoading(true); // Menandakan bahwa proses loading sedang berjalan
    const currentpage = parseInt('{{ $page; }}');
    const pkid = DOMPurify.sanitize(sessionStorage.getItem('admin_psikotest_kecermatan_id'))
    try {
        axios.defaults.withCredentials = true;
        axios.defaults.withXSRFToken = true;
        const csrfToken = await axios.get(`/sanctum/csrf-cookie`, {
            withCredentials: true,  // Mengirimkan cookie dalam permintaan
        });
        const response = await axios.get(`/api/kecermatan/soaljawaban/all/${pkid}?page=${currentpage}`, {
            withCredentials: true,  // Mengirimkan cookie dalam permintaan
            headers: {
                'Content-Type': 'application/json',
                'XSRF-TOKEN': csrfToken,
                'islogin' : DOMPurify.sanitize(localStorage.getItem('islogin')),
                'isadmin' : DOMPurify.sanitize(localStorage.getItem('isadmin')),
                'Authorization': `Bearer ${DOMPurify.sanitize(localStorage.getItem('pat'))}`,
                'remember-token': DOMPurify.sanitize(localStorage.getItem('remember-token')),
                'tokenlogin': '{{ $unique; }}',
                'email' : DOMPurify.sanitize(localStorage.getItem('email')),
                '--unique--': 'I am unique!',
                'isvalid': 'VALID!',
                'isallowed': true,
                'key': 'key',
                'values': 'values',
                'isdumb': 'no',
                'challenger': 'of course',
                'pranked': 'absolutely'
            }
        });
        console.info(response);
        // setDataPertanyaan(response.data.data.pertanyaan[0]);
        // setDataSoalJawaban(response.data.data.soaljawaban.data);
        // setLastpage(response.data.data.soaljawaban.last_page);

        document.getElementById('txt-kolom_x').innerHTML = response.data.data.pertanyaan[0].kolom_x;
        document.getElementById('txt-nilai_A').innerHTML = response.data.data.pertanyaan[0].nilai_A;
        document.getElementById('txt-nilai_B').innerHTML = response.data.data.pertanyaan[0].nilai_B;
        document.getElementById('txt-nilai_C').innerHTML = response.data.data.pertanyaan[0].nilai_C;
        document.getElementById('txt-nilai_D').innerHTML = response.data.data.pertanyaan[0].nilai_D;
        document.getElementById('txt-nilai_E').innerHTML = response.data.data.pertanyaan[0].nilai_E;

        const dataContainer = document.querySelector('#data-body');
        dataContainer.innerHTML = ''; // Clear existing content
        response.data.data.soaljawaban.data.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">${numbertable}</td>
                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">
                    ${item.soal_jawaban.soal[0][0]},
                    ${item.soal_jawaban.soal[0][1]},
                    ${item.soal_jawaban.soal[0][2]},
                    ${item.soal_jawaban.soal[0][3]}
                </td>
                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">
                    ${item.soal_jawaban.jawaban}
                </td>
                <td class="text-center p-2" style="border-bottom: 1px solid #aaa; border-right: 2px solid #000;">
                    <span onclick="toEditSoalJawaban(${pkid}, ${item.id}, '${item.soal_jawaban.soal[0][0]}', '${item.soal_jawaban.soal[0][1]}', '${item.soal_jawaban.soal[0][2]}', '${item.soal_jawaban.soal[0][3]}', '${item.soal_jawaban.jawaban}')">
                        <ion-icon name="pencil-outline"></ion-icon>
                        <span class="hidden">Edit</span>
                    </span>
                </td>
                <td class="text-center p-2" style="border-bottom: 1px solid #aaa;">
                    <span onclick="fDelete(${pkid}, ${item.id}, ${item.soal_jawaban.soal[0][0]}, ${item.soal_jawaban.soal[0][1]}, ${item.soal_jawaban.soal[0][2]}, ${item.soal_jawaban.soal[0][3]}, ${item.soal_jawaban.jawaban})">
                        <ion-icon name="trash-outline"></ion-icon>
                        <span class="hidden">Delete</span>
                    </span>
                </td>
            `;
            dataContainer.appendChild(tr);
            numbertable++;
        });

        const dataFooter = document.querySelector('#select-page');
        dataFooter.innerHTML = ''; // Clear existing content
        for(let x = 1; x <= response.data.data.soaljawaban.last_page; x++) {
            const option = document.createElement('option');
            option.value = x;
            option.textContent = x;
            if(x === currentpage) {
                option.selected = true;
            }
            dataFooter.appendChild(option);
        }

        document.getElementById('txt-lastpage').innerHTML = `/ ${response.data.data.soaljawaban.last_page}`;
    } catch (error) {
        console.info('Terjadi Error AdminPsikotestKecermatanDetil-getData:', error);
    }
    // setLoading(false);
};
function optionSelect() {
    const select = document.querySelector('#select-page');
    select.innerHTML = '';
    for (let x = 1; x <= parseInt(lastpage); x++) {
        const option = document.createElement('option');
        option.value = x;
        option.textContent = x;
        
        if(x === currentpage) {
            option.selected = true;
        }

        select.appendChild(option);
    }
}


document.addEventListener('DOMContentLoaded', function () {
    // getData(null);
    // optionSelect();
});