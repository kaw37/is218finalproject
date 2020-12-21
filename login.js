function validateForm(frm)
{
    if (frm.email.value === "")
    {
        alert("You must enter an email.");
        return false;
    }
    if (frm.password.value === "")
    {
        alert("You must enter a password.");
        return false;
    }
}
