$(document).ready(function () {
    $('.page-header').text('Contacts')
    $('.navlink-main').addClass('active')
    $('.navlink-add').removeClass('active')
    getData(currentPage);
})

let currentPage = 1;
const recordsPerPage = 10;
let currentSearch = '';

const getData = (page = 1, search = '') => {
    $.post('./src/routes/index.php', { method: 'Get', page: page, limit: recordsPerPage, search: search }, function (data, status) {
        let parsedData = JSON.parse(data);
        if (parsedData.status === 'Success') {
            let dataTable = '';
            parsedData.data.forEach(e => {
                dataTable += `
                <tr>
                    <td>${e.name}</td>
                    <td>${e.company}</td>
                    <td>${e.phone}</td>
                    <td>${e.email}</td>
                    <td>
                        <button class="edit-btn" value="${e.id}">Edit</button>
                        <button class="delete-btn" value="${e.id}">Delete</button>
                    </td>
                </tr>`;
            });
            $('#tables-append').html(dataTable);
            updatePaginationControls(parsedData.totalRecords, page);
        } else {
            $('#tables-append').html('<tr><td colspan="5">No data available</td></tr>');
        }
    });
};

const updatePaginationControls = (totalRecords, page) => {
    const totalPages = Math.ceil(totalRecords / recordsPerPage);
    let paginationHtml = '';

    for (let i = 1; i <= totalPages; i++) {
        paginationHtml += `<button class="page-btn" data-page="${i}">${i}</button>`;
    }

    $('#pageInfo').html(paginationHtml);
    currentPage = page;
    $('#prevPage').prop('disabled', page <= 1);
    $('#nextPage').prop('disabled', page >= totalPages);
};

const prevPage = () => {
    if (currentPage > 1) {
        getData(currentPage - 1, currentSearch);
    }
};

const nextPage = () => {
    getData(currentPage + 1, currentSearch);
};

$(document).on('click', '.edit-btn', function () {
    const contactId = $(this).val();
    location.href = `./editContact.php?id=${contactId}`;
});

$(document).ready(function () {
    getData(currentPage, currentSearch);

    $('#search').on('input', function () {
        currentSearch = $(this).val();
        getData(1, currentSearch); // Reset to page 1 on new search
    });

    $(document).on('click', '.page-btn', function () {
        const page = $(this).data('page');
        getData(page, currentSearch);
    });
});

