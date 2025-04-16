$('#general-search').on('input', async function () {
    const query = $(this).val();

    if (query.length < 3) return;

    try {
        const response = await axios.get('/general-search', {
            params: { query },
        });

        const results = response.data;
        const $datalist = $('#search-results');

        $datalist.empty();

        results.forEach(function (item) {
            const option = `<option value="${item.case_number || ''} - ${item.estimate || ''}"></option>`;
            $datalist.append(option);
        });
    } catch (error) {
        console.error('Error fetching search results:', error);
    }
});
