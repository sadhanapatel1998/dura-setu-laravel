<?php $__env->startSection('content'); ?>
<?php
extract(dura_page_data());
$err = [];
if (isset($errors) && $errors instanceof \Illuminate\Support\ViewErrorBag) {
    foreach ($errors->getBags() as $b) {
        foreach ($b->messages() as $k => $msgs) {
            $err[$k] = $msgs[0] ?? '';
        }
    }
} elseif (isset($errors) && is_array($errors)) {
    $err = $errors;
}
$formData = old() ?: ($formData ?? []);
?>


<main>
    <!-- Start Page Header -->
    <section class="cs_page_header cs_bg_filed" data-src="<?php echo e(asset('assets/img/breadcrumb-bg.jpg')); ?>">
        <div class="container">
            <div class="cs_page_header_text">
                <h1 class="cs_page_header_title cs_fs_64">Contact Us</h1>
                <ul class="cs_breadcrumb cs_mp_0 cs_fs_16">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Page Header -->

    <!-- Start Contact Section -->
    <section class="cs_contact_section cs_section_padding">
        <div class="container">
            <div class="row cs_gap_y_30">
                <div class="col-lg-4 order-lg-2" data-aos="fade-up">
                    <aside class="cs_contact_info cs_radius_20 ms-lg-auto">

                        <div class="cs_contact_info_item">
                            <h2 class="cs_fs_20 cs_semibold">Office Address</h2>
                            <p class="cs_fs_14 mb-0"><?php echo setting('address'); ?></p>
                        </div>

                        <div class="cs_contact_info_item">
                            <h2 class="cs_fs_20 cs_semibold">Call Us</h2>
                            <p class="cs_fs_14 mb-0">
                                <a href="tel:+<?php echo e(setting('phone')); ?>"><?php echo e(setting('phone_display')); ?></a><br>
                                <?php echo e(setting('contact_hours')); ?>

                            </p>
                        </div>

                        <div class="cs_contact_info_item">
                            <h2 class="cs_fs_20 cs_semibold">Email</h2>
                            <div class="cs_fs_14">
                                <a href="mailto:<?php echo e(setting('email')); ?>"><?php echo e(setting('email')); ?></a>
                                <div>We'll respond within 24 hours</div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-8">
                    <div class="cs_contact_form_wrap">
                        <h2 class="cs_fs_32 cs_semibold cs_contact_form_title mb-4">
                            Get in Touch With DuraSetu
                        </h2>
                        <form class="cs_contact_form" id="whatsappForm" method="POST" action="<?php echo e(url('contact')); ?>" data-validated="true" novalidate>
                            <!-- Anti-Spam Honeypot Field (Hidden from humans) -->
                            <div style="display:none !important; position:absolute; left:-9999px;" aria-hidden="true">
                                <input type="text" name="website_hp" tabindex="-1" autocomplete="off" value="">
                            </div>

                            <!-- Security Token & Render Timestamp -->
                            <input type="hidden" name="form_ts" value="<?php echo e(time()); ?>">
                            <input type="hidden" name="form_token" value="<?php echo e(csrf_token()); ?>">

                            <!-- General Error Alert -->
                            <div id="formGeneralError" class="cs_form_general_error mb-3" style="display:none;">
                                <i class="ri-error-warning-fill"></i>
                                <span><?= htmlspecialchars($err['general'] ?? ''); ?></span>
                            </div>

                            <!-- First Name Field -->
                            <div class="cs_form_input">
                                <label class="cs_form_label" for="fname">First Name</label>
                                <input class="cs_form_field cs_radius_5<?= !empty($err['first-name']) ? ' cs_input_invalid' : ''; ?>"
                                    type="text"
                                    id="fname"
                                    name="first-name"
                                    placeholder="Enter your first name"
                                    autocomplete="name"
                                    value="<?= htmlspecialchars($formData['first-name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    maxlength="50"
                                    required>
                                <div class="cs_field_error<?= !empty($err['first-name']) ? ' cs_has_error' : ''; ?>" id="fname_error"><?= htmlspecialchars($err['first-name'] ?? ''); ?></div>
                            </div>

                            <!-- Mobile Number Field -->
                            <div class="cs_form_input">
                                <label class="cs_form_label" for="phone">Mobile Number</label>
                                <input class="cs_form_field cs_radius_5<?= !empty($err['phone']) ? ' cs_input_invalid' : ''; ?>"
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    placeholder="Enter your Mobile Number"
                                    autocomplete="tel"
                                    value="<?= htmlspecialchars($formData['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    maxlength="16"
                                    required>
                                <div class="cs_field_error<?= !empty($err['phone']) ? ' cs_has_error' : ''; ?>" id="phone_error"><?= htmlspecialchars($err['phone'] ?? ''); ?></div>
                            </div>

                            <!-- Email Address Field -->
                            <div class="cs_form_input">
                                <label class="cs_form_label" for="email">Email Address</label>
                                <input class="cs_form_field cs_radius_5<?= !empty($err['email']) ? ' cs_input_invalid' : ''; ?>"
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email address"
                                    autocomplete="email"
                                    value="<?= htmlspecialchars($formData['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    maxlength="100"
                                    required>
                                <div class="cs_field_error<?= !empty($err['email']) ? ' cs_has_error' : ''; ?>" id="email_error"><?= htmlspecialchars($err['email'] ?? ''); ?></div>
                            </div>

                            <!-- Subject Field -->
                            <div class="cs_form_input">
                                <label class="cs_form_label" for="subject">Subject</label>
                                <input class="cs_form_field cs_radius_5<?= !empty($err['subject']) ? ' cs_input_invalid' : ''; ?>"
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    placeholder="How can DuraSetu help you?"
                                    value="<?= htmlspecialchars($formData['subject'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    maxlength="100">
                                <div class="cs_field_error<?= !empty($err['subject']) ? ' cs_has_error' : ''; ?>" id="subject_error"><?= htmlspecialchars($err['subject'] ?? ''); ?></div>
                            </div>

                            <!-- Message Field -->
                            <div class="cs_form_input cs_full">
                                <label class="cs_form_label" for="message">Message</label>
                                <textarea class="cs_form_field cs_radius_5<?= !empty($err['message']) ? ' cs_input_invalid' : ''; ?>"
                                    id="message"
                                    name="message"
                                    rows="5"
                                    placeholder="Tell us about the university, course or admission guidance you need..."
                                    maxlength="1000"><?= htmlspecialchars($formData['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                                <div class="cs_field_error<?= !empty($err['message']) ? ' cs_has_error' : ''; ?>" id="message_error"><?= htmlspecialchars($err['message'] ?? ''); ?></div>
                            </div>

                            <!-- Cloudflare Turnstile CAPTCHA -->
                            <div class="cs_form_input">
                                <div class="cf-turnstile"
                                    data-sitekey="<?php echo e(setting('turnstile_site_key')); ?>"
                                    data-theme="light"
                                    data-size="normal">
                                </div>

                                <div class="cs_field_error" id="captcha_error"></div>
                            </div>

                            <!-- Submit Button & Feedback Alerts -->
                            <div class="cs_form_input">
                                <button type="submit" class="cs_primary_btn" id="contactSubmitBtn">
                                    <span>Send on WhatsApp</span>
                                    <span><i class="ri-whatsapp-line"></i></span>
                                </button>
                                <div id="formSuccessAlert" style="display:none;" class="cs_form_success_msg mt-3">
                                    <i class="ri-checkbox-circle-fill"></i>
                                    <span>Thank you! Your enquiry has been verified and opened in WhatsApp.</span>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->

</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("whatsappForm");
        if (!form) return;

        const fnameInput = document.getElementById("fname");
        const phoneInput = document.getElementById("phone");
        const emailInput = document.getElementById("email");
        const subjectInput = document.getElementById("subject");
        const messageInput = document.getElementById("message");
        const submitBtn = document.getElementById("contactSubmitBtn") || form.querySelector('button[type="submit"]');
        const successAlert = document.getElementById("formSuccessAlert");
        const generalError = document.getElementById("formGeneralError");

        function setError(input, errorId, message) {
            if (!input) return;
            input.classList.add("cs_input_invalid");
            input.setAttribute("aria-invalid", "true");
            const errEl = document.getElementById(errorId);
            if (errEl) {
                errEl.textContent = message;
                errEl.classList.add("cs_has_error");
            }
        }

        function clearError(input, errorId) {
            if (!input) return;
            input.classList.remove("cs_input_invalid");
            input.removeAttribute("aria-invalid");
            const errEl = document.getElementById(errorId);
            if (errEl) {
                errEl.textContent = "";
                errEl.classList.remove("cs_has_error");
            }
        }

        function clearAllErrors() {
            clearError(fnameInput, "fname_error");
            clearError(phoneInput, "phone_error");
            clearError(emailInput, "email_error");
            if (subjectInput) clearError(subjectInput, "subject_error");
            clearError(messageInput, "message_error");
            if (generalError) {
                generalError.innerHTML = "";
                generalError.style.display = "none";
            }
            if (successAlert) {
                successAlert.style.display = "none";
            }
        }

        // Clear field-level error on typing
        [fnameInput, phoneInput, emailInput, subjectInput, messageInput].forEach(function(el) {
            if (!el) return;
            el.addEventListener("input", function() {
                clearError(this, this.id + "_error");
            });
        });

        // Client-side validation function
        function validateClientForm() {
            clearAllErrors();
            let isValid = true;
            let firstInvalidField = null;

            // 1. Name Validation
            const nameVal = fnameInput.value.trim();
            if (nameVal === "") {
                setError(fnameInput, "fname_error", "Please enter your name.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = fnameInput;
            } else if (nameVal.length < 2) {
                setError(fnameInput, "fname_error", "Name must be at least 2 characters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = fnameInput;
            } else if (nameVal.length > 50) {
                setError(fnameInput, "fname_error", "Name must not exceed 50 characters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = fnameInput;
            } else if (/\d/.test(nameVal)) {
                setError(fnameInput, "fname_error", "Name cannot contain numbers.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = fnameInput;
            } else if (!/^[a-zA-Z\s.'-]+$/.test(nameVal)) {
                setError(fnameInput, "fname_error", "Name can only contain letters, spaces, and hyphens.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = fnameInput;
            } else if (!/[a-zA-Z].*[a-zA-Z]/.test(nameVal)) {
                setError(fnameInput, "fname_error", "Please enter a valid name with at least 2 letters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = fnameInput;
            }

            // 2. Phone Validation (Indian 10-digit mobile)
            const rawPhone = phoneInput.value.trim();
            if (rawPhone === "") {
                setError(phoneInput, "phone_error", "Please enter your mobile number.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = phoneInput;
            } else if (/[a-zA-Z]/.test(rawPhone)) {
                setError(phoneInput, "phone_error", "Phone number cannot contain letters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = phoneInput;
            } else {
                let digits = rawPhone.replace(/\D/g, "");
                if (digits.length === 12 && digits.startsWith("91")) {
                    digits = digits.substring(2);
                } else if (digits.length === 11 && digits.startsWith("0")) {
                    digits = digits.substring(1);
                }

                const dummySequential = ['1234567890', '0123456789', '9876543210', '0987654321', '2345678901', '3456789012'];
                if (digits.length !== 10) {
                    setError(phoneInput, "phone_error", "Please enter a valid 10-digit mobile number.");
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = phoneInput;
                } else if (!/^[6-9]\d{9}$/.test(digits)) {
                    setError(phoneInput, "phone_error", "Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9.");
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = phoneInput;
                } else if (/^(\d)\1{9}$/.test(digits)) {
                    setError(phoneInput, "phone_error", "Please enter a valid mobile number.");
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = phoneInput;
                } else if (dummySequential.indexOf(digits) !== -1) {
                    setError(phoneInput, "phone_error", "Please enter a valid mobile number.");
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = phoneInput;
                }
            }

            // 3. Email Validation
            const emailVal = emailInput.value.trim();
            const emailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            if (emailVal === "") {
                setError(emailInput, "email_error", "Please enter your email address.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = emailInput;
            } else if (emailVal.length > 100) {
                setError(emailInput, "email_error", "Email must not exceed 100 characters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = emailInput;
            } else if (emailVal.indexOf("..") !== -1 || !emailRegex.test(emailVal)) {
                setError(emailInput, "email_error", "Please enter a valid email address.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = emailInput;
            } else {
                const parts = emailVal.split("@");
                const domainParts = parts[1] ? parts[1].split(".") : [];
                const tld = domainParts[domainParts.length - 1] || "";
                if (tld.length < 2) {
                    setError(emailInput, "email_error", "Please enter a valid email address.");
                    isValid = false;
                    if (!firstInvalidField) firstInvalidField = emailInput;
                }
            }

            // 4. Message Validation
            const msgVal = messageInput.value.trim();
            if (msgVal === "") {
                setError(messageInput, "message_error", "Message must contain at least 10 characters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = messageInput;
            } else if (msgVal.length < 10) {
                setError(messageInput, "message_error", "Message must contain at least 10 characters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = messageInput;
            } else if (msgVal.length > 1000) {
                setError(messageInput, "message_error", "Message must not exceed 1000 characters.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = messageInput;
            } else if (/^(.)\1{9,}$/.test(msgVal)) {
                setError(messageInput, "message_error", "Please enter a meaningful message.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = messageInput;
            } else if (!/[a-zA-Z0-9]/.test(msgVal)) {
                setError(messageInput, "message_error", "Message must contain meaningful text.");
                isValid = false;
                if (!firstInvalidField) firstInvalidField = messageInput;
            }

            if (!isValid && firstInvalidField) {
                firstInvalidField.focus();
            }

            return isValid;
        }

        let isSubmitting = false;

        form.addEventListener("submit", function(e) {
            e.preventDefault();

            // Prevent accidental duplicate rapid submissions
            if (isSubmitting) return;

            // Perform client-side checks
            if (!validateClientForm()) {
                return;
            }

            // Check Cloudflare Turnstile
            const turnstileResponse = form.querySelector(
                '[name="cf-turnstile-response"]'
            )?.value;

            if (!turnstileResponse) {
                const captchaError = document.getElementById("captcha_error");

                if (captchaError) {
                    captchaError.textContent =
                        "Please complete the security verification.";
                    captchaError.classList.add("cs_has_error");
                }

                return;
            }

            isSubmitting = true;
            const originalBtnHTML = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.style.opacity = "0.8";
            submitBtn.innerHTML = '<span>Verifying...</span> <span><i class="ri-loader-4-line ri-spin"></i></span>';

            const formData = new FormData(form);
            formData.append("is_ajax", "1");

            fetch(form.action || "<?php echo e(url('contact')); ?>", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    if (data.status === "success") {
                        if (successAlert) {
                            successAlert.style.display = "flex";
                        }
                        // Open WhatsApp in new tab
                        if (data.whatsapp_url) {
                            window.open(data.whatsapp_url, "_blank");
                        }
                        // Prevent duplicate submission by keeping button disabled briefly
                        setTimeout(function() {
                            submitBtn.disabled = false;
                            submitBtn.style.opacity = "1";
                            submitBtn.innerHTML = originalBtnHTML;
                            isSubmitting = false;
                        }, 4000);
                    } else if (data.status === "error" && data.errors) {
                        let firstInvalid = null;
                        for (const fieldKey in data.errors) {
                            let inputEl = null;
                            let errorId = "";
                            if (fieldKey === "first-name") {
                                inputEl = fnameInput;
                                errorId = "fname_error";
                            } else if (fieldKey === "phone") {
                                inputEl = phoneInput;
                                errorId = "phone_error";
                            } else if (fieldKey === "email") {
                                inputEl = emailInput;
                                errorId = "email_error";
                            } else if (fieldKey === "subject") {
                                inputEl = subjectInput;
                                errorId = "subject_error";
                            } else if (fieldKey === "message") {
                                inputEl = messageInput;
                                errorId = "message_error";
                            } else if (fieldKey === "general" && generalError) {
                                generalError.innerHTML = '<i class="ri-error-warning-fill"></i> <span>' + data.errors[fieldKey] + '</span>';
                                generalError.style.display = "flex";
                            }

                            if (inputEl && errorId) {
                                setError(inputEl, errorId, data.errors[fieldKey]);
                                if (!firstInvalid) firstInvalid = inputEl;
                            }
                        }
                        if (firstInvalid) firstInvalid.focus();
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = "1";
                        submitBtn.innerHTML = originalBtnHTML;
                        isSubmitting = false;
                    }
                })
                .catch(function(err) {
                    // Fallback to native post submission if network error
                    form.submit();
                });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/site/contact.blade.php ENDPATH**/ ?>