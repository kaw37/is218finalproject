function validateForm(frm)
{
    // return true;
    // alert("validate form");
    if (frm.questionName.value === "")
    {
        alert("You must enter a Question Name.");
        return false;
    }
    if (frm.questionSkills.value === "")
    {
        alert("You must enter a Question Skill.");
        return false;
    }
    if (frm.questionBody.value === "")
    {
        alert("You must enter a Question Body.");
        return false;
    }
}