<div class="row g-3">

    <div class="col-md-6">

        <label class="form-label">
            Company Code
        </label>

        <input
            type="text"
            name="company_code"
            class="form-control"
            maxlength="20"
            required
            value="<?= htmlspecialchars(
                $company['company_code'] ?? ''
            ) ?>">

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Company Name
        </label>

        <input
            type="text"
            name="company_name"
            class="form-control"
            maxlength="150"
            required
            value="<?= htmlspecialchars(
                $company['company_name'] ?? ''
            ) ?>">

    </div>


    <div class="col-12">

        <label class="form-label">
            Address
        </label>

        <textarea
            name="address"
            class="form-control"
            maxlength="255"
            rows="3"><?= htmlspecialchars(
                $company['address'] ?? ''
            ) ?></textarea>

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Telephone
        </label>

        <input
            type="text"
            name="telephone"
            class="form-control"
            maxlength="50"
            value="<?= htmlspecialchars(
                $company['telephone'] ?? ''
            ) ?>">

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Email
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            maxlength="100"
            value="<?= htmlspecialchars(
                $company['email'] ?? ''
            ) ?>">

    </div>


    <div class="col-md-6">

        <label class="form-label">
            Status
        </label>

        <select
            name="status"
            class="form-select">

            <option
                value="Active"
                selected>

                Active

            </option>

            <option
                value="Inactive">

                Inactive

            </option>

        </select>

    </div>

</div>