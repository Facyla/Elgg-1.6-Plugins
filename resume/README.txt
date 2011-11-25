Summary :
- changes
- howto
- original plugin data structure
- 1st round data structure
- Europass data structure
- 2nd round data structure


#########################################
CHANGES by Facyla :

1st round : 20110516
  - merge work + academic + training + reference into experience
  - keep language
  => change object type to "experience"
  => use subtype as a new metadata
  => use common data types (for all "experiences")

2nd round : 20110518
  - add several types and corresponding actions+forms+views : experience, language, education, workexperience, skill, skill_ciiee
    (note : ciiee refers to C2i2e but one can't use number in Elgg data types)
  - lazy normalization to Europass format (contact items are not detailed + skills don't include driving licences yet)
  - move listings from start.php to resume views
  - no longer replace the userdetails view (extend it instead)
  - collapsible boxes are collapsed by default
  - admin settings : activate data types


#########################################

#########################################
Object types : rWork, rAcademic

work
  startdate
  enddate
  organisation
  jobtitle
  description
  title
  subtype = "rWork"
academic
  level
  enddate
  institution
  achieved_title
  subtype = "rAcademic"
training
  training_type
  enddate
  institution
  name
  subtype = "rTraining"
reference
  name
  occupation
  organisation
  jobtitle
  tel
  subtype = "rReference"
language
  language
  written
  read
  spoken
  subtype = "rLanguage"



#########################################
1st round data structure :
experience
  (title) => déduit des autres infos = (typology :) jobtitle @ organisation
  structure => organisation / institution
  startdate
  enddate
  heading = jobtitle / achieved_title / training_type / name => intitulé du poste, diplôme, fonction, stage, etc.
  description / occupation => texte long
  +typology => subtype = rWork/rAcademic/rTraining/rReference/etc. => types d'expériences
  +importance => relative, appréciation personnelle
  +contact / name / tel => contact (champ court)
  +level ?

language => identical to original rLanguage object

Target data structure :
experience
  structure
  startdate
  enddate
  heading
  description
  typology : work (professionnelle) / academic (formation) / reference (projets et autres expériences)
  importance
  contact
  title



#########################################
// Europass data structure - indicative

workexperiencelist
  workexperience
    period
      from
        year
        month
        day
      to
        year
        month
        day
    position
      code
      label
    activities
      employer
        name
        address
          addressLine
          municipality
          postalCode
          country
            code
            label
    sector
      code
      label

educationlist
  education
    period
      from
        year
        month
        day
      to
        year
        month
        day
    title
    skills
    organisation
      name
        address
          addressLine
          municipality
          postalCode
          country
            code
            label
      type
    level
      code
      label
    educationalfield
      code
      label

languagelist
  language xsi:type="europass:mother"
    code
    label
  language xsi:type="europass:foreign"
    code
    label
    level
      (understanding)
      listening
       
      (speaking)
      spokeninteraction
      spokenproduction
      (writing)
      writing

skilllist
  skill type="social"
  skill type="organisational"
  skill type="technical"
  skill type="computer"
  skill type="artistic"
  skill type="other"
  structured-skill xsi:type="europass:driving"
    drivinglicence

misclist
  misc type="additional"
  misc type="annexes"


#########################################
// Implemented data structure => check resume/views/default/object/* or resume/actions/* to verify actual data structure

workexperience
  startdate
  enddate
  heading
  position
  activities
  structure
  contact
  sector

education
  startdate
  enddate
  title
  structure
  contact
  skills
  level
  field

language
  language
  type
  listening
  reading
  spokeninteraction
  spokenproduction
  writing

skill
  skilltype
  skillcontent

