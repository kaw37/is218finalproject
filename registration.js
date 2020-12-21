function validateForm(frm)
{
    if (frm.firstName.value === "")
    {
        alert("You must enter a first name.");
        return false;
    }
    if (frm.lastName.value === "")
    {
        alert("You must enter a last name.");
        return false;
    }
    if (frm.birthday.value === "")
    {
        alert("You must enter a birthday.");
        return false;
    }
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