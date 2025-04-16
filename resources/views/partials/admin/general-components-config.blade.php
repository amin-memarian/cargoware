

<script>

    window.costReviewComponentStoreRoute = @json(route('cost-review.store'));
    window.employeesManagementStoreRoute = @json(route('employees.store'));
    window.checkMobileExistRoute = @json(route('users.check-mobile-exist'));
    window.employeesCheckMobileExistRoute = @json(route('employees.check-mobile-exist'));
    window.configRoute = @json(route('configs.index'));

    // submit-load
    window.debounceTimeout = null;
    window.countries = @json($countries);
    window.componentSearchUserRoute = @json(route('admin.search_users'));

    // register-user
    window.componentUserStoreRoute = @json(route('users.store'));
    window.componentUserListRoute = @json(route('users.index'));

    // customer invoice
    window.searchAllUsersRoute = @json(route('search-all-users'));
    window.searchUserCasesRoute = @json(route('search-user-cases', ['term' => ':term']));

</script>
