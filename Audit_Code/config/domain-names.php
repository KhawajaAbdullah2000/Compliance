<?php

/**
 * Domain-name look-ups by project_type.
 * Usage:  $domainNames = config('domain-names')[ $projectType ] ?? [];
 */

return [

    /*
    |--------------------------------------------------------------------------
    | PCI DSS – Single Service Provider
    |--------------------------------------------------------------------------
    */
    1 => [
        1  => 'Install and Maintain Network Security Controls',
        2  => 'Apply Secure Configurations to All System Components',
        3  => 'Protect Stored Account Data',
        4  => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
        5  => 'Protect All Systems and Networks from Malicious Software',
        6  => 'Develop and Maintain Secure Systems and Software',
        7  => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
        8  => 'Identify Users and Authenticate Access to System Components',
        9  => 'Restrict Physical Access to Cardholder Data',
        10 => 'Log and Monitor All Access to System Components and Cardholder Data',
        11 => 'Test Security of Systems and Networks Regularly',
        12 => 'Support Information Security with Organizational Policies and Programs',
        'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections',
    ],

    /*
    |--------------------------------------------------------------------------
    | PCI DSS – Multi-Tenant Service Provider
    |--------------------------------------------------------------------------
    */
    2 => [
        1  => 'Install and Maintain Network Security Controls',
        2  => 'Apply Secure Configurations to All System Components',
        3  => 'Protect Stored Account Data',
        4  => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
        5  => 'Protect All Systems and Networks from Malicious Software',
        6  => 'Develop and Maintain Secure Systems and Software',
        7  => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
        8  => 'Identify Users and Authenticate Access to System Components',
        9  => 'Restrict Physical Access to Cardholder Data',
        10 => 'Log and Monitor All Access to System Components and Cardholder Data',
        11 => 'Test Security of Systems and Networks Regularly',
        12 => 'Support Information Security with Organizational Policies and Programs',
        'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
        'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
    ],

    /*
    |--------------------------------------------------------------------------
    | PCI DSS – Merchant
    |--------------------------------------------------------------------------
    */
    3 => [
        1  => 'Install and Maintain Network Security Controls',
        2  => 'Apply Secure Configurations to All System Components',
        3  => 'Protect Stored Account Data',
        4  => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
        5  => 'Protect All Systems and Networks from Malicious Software',
        6  => 'Develop and Maintain Secure Systems and Software',
        7  => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
        8  => 'Identify Users and Authenticate Access to System Components',
        9  => 'Restrict Physical Access to Cardholder Data',
        10 => 'Log and Monitor All Access to System Components and Cardholder Data',
        11 => 'Test Security of Systems and Networks Regularly',
        12 => 'Support Information Security with Organizational Policies and Programs',
        'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections',
    ],

    /*
    |--------------------------------------------------------------------------
    | ISO 27001 Sections 4-10
    |--------------------------------------------------------------------------
    */
    4 => [
        4  => 'Context of the Organization',
        5  => 'Leadership',
        6  => 'Planning',
        7  => 'Support',
        8  => 'Operation',
        9  => 'Performance Evaluation',
        10 => 'Improvement',
        11 => 'Annex-A',
    ],

    'iso_health_of_controls' => [
        4  => 'Context of the Organization',
        5  => 'Leadership',
        6  => 'Planning',
        7  => 'Support',
        8  => 'Operation',
        9  => 'Performance Evaluation',
        10 => 'Improvement',
        11 => 'Annex-A 5. Organization Controls',
        12 => 'Annex-A 6. People Controls',
        13 => 'Annex-A 7. Physical Controls',
        14=> 'Annex-A 8. Technological Controls',
    ],

    /*
    |--------------------------------------------------------------------------
    | SAMA CSF (excerpt – 3.x family)
    |--------------------------------------------------------------------------
    */
    5 => [
        '3.1' => 'Cybersecurity Leadership and Governance',
        '3.2' => 'Cybersecurity Risk Management and Compliance',
        '3.3' => 'Cybersecurity Operations and Technology',
        '3.4' => 'Third-Party Cybersecurity',
    ],

    /*
    |--------------------------------------------------------------------------
    | SBP ETGRMF
    |--------------------------------------------------------------------------
    */
    6 => [
        1 => 'INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)',
        2 => 'INFORMATION SECURITY',
        3 => 'IT SERVICES DELIVERY & OPERATIONS MANAGEMENT',
        4 => 'ACQUISITION & IMPLEMENTATION OF IT SYSTEMS',
        5 => 'BUSINESS CONTINUITY AND DISASTER RECOVERY',
        6 => 'IT AUDIT',
    ],

    /*
    |--------------------------------------------------------------------------
    | KSA NCA
    |--------------------------------------------------------------------------
    */
    7 => [
        1 => 'Cybersecurity Governance',
        2 => 'Cybersecurity Defense',
        3 => 'Cybersecurity Resilience',
        4 => 'Third-Party and Cloud Computing Cybersecurity',
        5 => 'Industrial Control Systems Cybersecurity',
    ],

    23 => [
        1 => 'Govern',
        2 => 'Identify',
        3 => 'Protect',
        4 => 'Detect',
        5 => 'Respond',
        6 => 'Recover'

    ],

    24 => [
        '5.2' => 'Context of the organization',
        '5.3' => 'Leadership',
        '5.4' => 'Planning',
        '5.5' => "Support",
        '5.6' => "Operation",
        '5.7' => 'Performance Evaluation',
        '5.8' => 'Improvement',
        '6.2' => 'ISO 27002:2013 aspects of PII',
        '6.3' => 'ISO 27002:2013 aspects of PII',
        '6.4' => 'ISO 27002:2013 aspects of PII',
        '6.5' => 'ISO 27002:2013 aspects of PII',
        '6.6' => 'ISO 27002:2013 aspects of PII',
        '6.6.2' => 'User access management aspects of PII',
        '6.6.4' => 'System and application access control aspects of PII',
        '6.7.1' => 'Cryptographic controls control aspects of PII',
        '6.8.2' => 'Equipment control aspects of PII',
        '6.9.3' => 'Backup control aspects of PII',
        '6.9.4' => 'Logging and monitoring control aspects of PII',
        '6.11.2' => 'Security requirements of information systems control aspects of PII',
        '6.13.1' => 'Management of information security incidents and improvements aspects of PII',
        '6.15.2' => 'Information security reviews aspects of PII',
        'A' => 'PIMS-specific reference control objectives and controls for PII Controllers',
        'B' => 'PIMS-specific reference control objectives and controls for PII Processors'

    ],

    /*
    |--------------------------------------------------------------------------
    | UAE-IA Information Assurance
    |--------------------------------------------------------------------------
    */
    8 => [
        'M1.1' => 'ENTITY CONTEXT AND LEADERSHIP',
        'M1.2' => 'INFORMATION SECURITY POLICY',
        'M1.3' => 'ORGANIZATION OF INFORMATION SECURITY',
        'M1.4' => 'SUPPORT',

        'M2.1' => 'INFORMATION SECURITY RISK MANAGEMENT POLICY',
        'M2.2' => 'INFORMATION SECURITY RISK ASSESSMENT',
        'M2.3' => 'INFORMATION SECURITY RISK TREATMENT',
        'M2.4' => 'ONGOING INFORMATION SECURITY RISK MANAGEMENT',

        'M3.1' => 'AWARENESS AND TRAINING POLICY',
        'M3.2' => 'AWARENESS AND TRAINING PLANNING',
        'M3.3' => 'SECURITY TRAINING',
        'M3.4' => 'SECURITY AWARENESS',

        'M4.1' => 'HUMAN RESOURCES SECURITY POLICY',
        'M4.2' => 'PRIOR TO EMPLOYMENT',
        'M4.3' => 'DURING EMPLOYMENT',
        'M4.4' => 'TERMINATION OR CHANGE OF EMPLOYMENT',

        'M5.1' => 'COMPLIANCE POLICY',
        'M5.2' => 'COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS',
        'M5.3' => 'COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS',
        'M5.4' => 'COMPLIANCE WITH TECHNICAL REQUIREMENTS',
        'M5.5' => 'INFORMATION SYSTEMS AUDIT CONSIDERATIONS',

        'M6.1' => 'PERFORMANCE EVALUATION POLICY',
        'M6.2' => 'PERFORMANCE EVALUATION',
        'M6.3' => 'IMPROVEMENT',

        'T1.1' => 'ASSET MANAGEMENT POLICY',
        'T1.2' => 'RESPONSIBILITY FOR ASSETS',
        'T1.3' => 'INFORMATION CLASSIFICATION',
        'T1.4' => 'MEDIA HANDLING',

        'T2.1' => 'PHYSICAL AND ENVIRONMENTAL SECURITY POLICY',
        'T2.2' => 'SECURE AREAS',
        'T2.3' => 'EQUIPMENT SECURITY',

        'T3.1' => 'OPERATIONS MANAGEMENT POLICY',
        'T3.2' => 'OPERATIONAL PROCEDURES AND RESPONSIBILITIES',
        'T3.3' => 'SYSTEM PLANNING AND ACCEPTANCE',
        'T3.4' => 'PROTECTION FROM MALWARE',
        'T3.5' => 'BACKUP',
        'T3.6' => 'MONITORING',

        'T4.1' => 'COMMUNICATIONS POLICY',
        'T4.2' => 'INFORMATION TRANSFER',
        'T4.3' => 'ELECTRONIC COMMERCE SERVICES',
        'T4.4' => 'INFORMATION SHARING PROTECTION',
        'T4.5' => 'NETWORK SECURITY MANAGEMENT',

        'T5.1' => 'ACCESS CONTROL POLICY',
        'T5.2' => 'USER ACCESS MANAGEMENT',
        'T5.3' => 'USER RESPONSIBILITIES',
        'T5.4' => 'NETWORK ACCESS CONTROL',
        'T5.5' => 'OPERATING SYSTEM ACCESS CONTROL',
        'T5.6' => 'APPLICATION AND INFORMATION ACCESS CONTROL',
        'T5.7' => 'MOBILE DEVICES ACCESS CONTROL',

        'T6.1' => 'THIRD-PARTY SECURITY POLICY',
        'T6.2' => 'THIRD-PARTY SERVICE DELIVERY MANAGEMENT',
        'T6.3' => 'CLOUD COMPUTING',

        'T7.1' => 'INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY',
        'T7.2' => 'SECURITY REQUIREMENTS OF INFORMATION SYSTEMS',
        'T7.3' => 'CORRECT PROCESSING IN APPLICATIONS',
        'T7.4' => 'CRYPTOGRAPHIC CONTROLS',
        'T7.5' => 'SECURITY OF SYSTEM FILES',
        'T7.6' => 'SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES',
        'T7.7' => 'TECHNICAL VULNERABILITY MANAGEMENT',
        'T7.8' => 'SUPPLY CHAIN MANAGEMENT',

        'T8.1' => 'INFORMATION SECURITY INCIDENT MANAGEMENT POLICY',
        'T8.2' => 'MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS',
        'T8.3' => 'INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING',

        'T9.1' => 'INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY',
        'T9.2' => 'INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT',
        'T9.3' => 'TESTING, MAINTAINING, AND REASSESSING PLANS',
    ],

    /*
    |--------------------------------------------------------------------------
    | ISA/IEC 62443-4-1 Secure Product Development Lifecycle
    |--------------------------------------------------------------------------
    */
    9 => [
        '5.2'  => 'SM-1: Development process',
        '5.3'  => 'SM-2: Identification of responsibilities',
        '5.4'  => 'SM-3: Identification of applicability',
        '5.5'  => 'SM-4: Security expertise',
        '5.6'  => 'SM-5: Process scoping',
        '5.7'  => 'SM-6: File integrity',
        '5.8'  => 'SM-7: Development environment security',
        '5.9'  => 'SM-8: Controls for private keys',
        '5.10' => 'SM-9: Security requirements for externally provided components',
        '5.11' => 'SM-10: Custom developed components from third-party suppliers',
        '5.12' => 'SM-11: Assessing and addressing security-related issues',
        '5.13' => 'SM-12: Process verification',
        '5.14' => 'SM-13: Continuous improvement',

        '6.2'  => 'SR-1: Product security context',
        '6.3'  => 'SR-2: Threat model',
        '6.4'  => 'SR-3: Product security requirements',
        '6.5'  => 'SR-4: Product security requirements content',
        '6.6'  => 'SR-5: Security requirements review',

        '7.2'  => 'SD-1: Secure design principles',
        '7.3'  => 'SD-2: Defense in depth design',
        '7.4'  => 'SD-3: Security design review',
        '7.5'  => 'SD-4: Secure design best practices',

        '8.3'  => 'SI-1: Security implementation review',
        '8.4'  => 'SI-2: Secure coding standards',

        '9.2'  => 'SVV-1: Security requirements testing',
        '9.3'  => 'SVV-2: Threat mitigation testing',
        '9.4'  => 'SVV-3: Vulnerability testing',
        '9.5'  => 'SVV-4: Penetration testing',
        '9.6'  => 'SVV-5: Independence of testers',

        '10.2' => 'DM-1: Receiving notifications of security-related issues',
        '10.3' => 'DM-2: Reviewing security-related issues',
        '10.4' => 'DM-3: Assessing security-related issues',
        '10.5' => 'DM-4: Addressing security-related issues',
        '10.6' => 'DM-5: Disclosing security-related issues',
        '10.7' => 'DM-6: Periodic review of security defect management practice',

        '11.2' => 'SUM-1: Security update qualification',
        '11.3' => 'SUM-2: Security update documentation',
        '11.4' => 'SUM-3: Dependent component or OS security update documentation',
        '11.5' => 'SUM-4: Security update delivery',
        '11.6' => 'SUM-5: Timely delivery of security patches',

        '12.2' => 'SG-1: Product defense in depth',
        '12.3' => 'SG-2: Defense in depth measures expected in the environment',
        '12.4' => 'SG-3: Security hardening guidelines',
        '12.5' => 'SG-4: Secure disposal guidelines',
        '12.6' => 'SG-5: Secure operation guidelines',
        '12.7' => 'SG-6: Account management guidelines',
        '12.8' => 'SG-7: Documentation review',
    ],

    /*
    |--------------------------------------------------------------------------
    | IEC 62443-3-3 : 4-2 / 3-3 / 2-1 etc.  (summarised)
    |--------------------------------------------------------------------------
    */
    10 => [
        '4.2' => 'ZCR 1: Identify the SUC',
        '4.3' => 'ZCR 2: Initial Cyber Security Risk Assessment',
        '4.4' => 'ZCR 3: Partition the SUC into Zones and Conduits',
        '4.5' => 'ZCR 4: Risk Comparison',
        '4.6' => 'ZCR 5: Perform a Detailed Cyber Security Risk Assessment',
        '4.7' => 'ZCR 6: Document Cyber Security Requirements, Assumptions, and Constraints',
        '4.8' => 'ZCR 7: Asset Owner Approval',
    ],

    11 => [
        '4.2.2' => 'Business Rationale',
        '4.2.3' => 'Risk Identification, Classification, and Assessment',
        '4.3.2' => 'Security Policy, Organization, and Awareness',
        '4.3.3' => 'Selected Security Countermeasures',
        '4.3.4' => 'Implementation',
        '4.4.2' => 'Conformance',
        '4.4.3' => 'Review, Improve, and Maintain the CSMS',
    ],

    12 => [
        '5'  => 'FR 1 – Identification and authentication control',
        '6'  => 'FR 2 – Use control',
        '7'  => 'FR 3 – System integrity',
        '8'  => 'FR 4 – Data confidentiality',
        '9'  => 'FR 5 – Restricted data flow',
        '10' => 'FR 6 – Timely response to events',
        '11' => 'FR 7 – Resource availability',
        '12' => 'Software application requirements',
        '13' => 'Embedded device requirements',
        '14' => 'Host device requirements',
        '15' => 'Network device requirements',
    ],

    13 => [
        '5'  => 'FR 1 – Identification and authentication control',
        '6'  => 'FR 2 – Use control',
        '7'  => 'FR 3 – System integrity',
        '8'  => 'FR 4 – Data confidentiality',
        '9'  => 'FR 5 – Restricted data flow',
        '10' => 'FR 6 – Timely response to events',
        '11' => 'FR 7 – Resource availability',
    ],

    /*
    |--------------------------------------------------------------------------
    | COSO – Internal Control Framework
    |--------------------------------------------------------------------------
    */
    18 => [
        1 => 'Control Environment',
        2 => 'Risk Assessment',
        3 => 'Control Activities',
        4 => 'Information and Communication',
        5 => 'Monitoring',
    ],

    /*
    |--------------------------------------------------------------------------
    | SOC 2 – Trust Services Criteria (short-listing)
    |--------------------------------------------------------------------------
    */
    19 => [
        'Section 1'=>"Independent Service Auditor's Report",
        'Section 2'=>"Assertation of Assessed Entity",
        'Section 3'=>"Assessed Entity's Description of Its Services Throughout the Assessment Period",
        'TSC1'=>"Security",
        'Section 4'=>"Trust Services Criteria, Related Controls and Tests of Controls Relevant to the Security Category",
        // 1  => 'Asset Management',
        // 2  => 'Availability',
        // 3  => 'Change Management',
        // 4  => 'Communications',
        // 5  => 'Confidentiality',
        // 6  => 'Data Classification',
        // 7  => 'Fraud Management',
        // 8  => 'Human Resource aspects of Trust Services',
        // 9  => 'Information Assets Security Management Policy',
        // 10 => 'Information Security Events Monitoring',
        // 11 => 'Information Security Incident Management',
        // 12 => 'Information Security Monitoring',
        // 13 => 'IT Operational Anomalies Reporting',
        // 14 => 'Logical and Physical Access Controls',
        // 15 => 'Monitoring of Controls',
        // 16 => 'Organization & Management',
        // 17 => 'Risk Management',
        // 18 => 'Vendor and Business Partner Risk Management',
        // 19 => 'Vulnerability Management',
    ],

    // COBIT 2019
    16 => [
        '1' => 'EDM',
        '2' => 'APO',
        '3' => 'BAI',
        '4' => 'DSS',
        '5' => 'MEA'

    ],

    //DIgital banking security
    25 => [
        '1' => 'Governance',
        '2' => 'Management Controls',
        '3' => 'Operational Controls',
        '4' => 'Liability Framework'
    ],

    //SBP Payment card securityStandard
    26 => [
        '4' => 'Consumer Awareness & Record Retention',
        '5' => 'Consumer Awareness & Record Retention',
        '6' => 'Roadmap for EMV Compliance',

    ],

    //ISO 22301:2019
    29 => [
        '4' => 'Context of the organization',
        '5' => 'Leadership',
        '6' => 'Planning',
        '7' => 'Support',
        '8' => 'Operation',
        '9' => 'Performance evaluation',
        '10' => 'Improvement'

    ],
    30 => [
        '4' => 'Context of the organization',
        '5' => 'Leadership',
        '6' => 'Planning',
        '7' => 'Support',
        '8' => 'Operation',
        '9' => 'Performance evaluation',
        '10' => 'Improvement'

    ]

];
