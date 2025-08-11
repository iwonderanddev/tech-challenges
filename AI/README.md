# AI/ML Engineer Challenge: Product Recommendation System

## Overview

Design and implement a machine learning solution for product placement recommendations in retail guidelines. This challenge evaluates your ability to build efficient, maintainable ML systems from complex hierarchical data.

**Note:** This challenge simulates real-world ML engineering scenarios. Focus on building something that works well rather than perfect - we're interested in your problem-solving approach and engineering practices. Keep your development time in check and don't drag yourself into a 10+ hours implementation.

## Problem Statement

You'll work with 6,000 guideline documents representing retail shelf layouts. Each guideline contains:
- **Bays** (sections of shelving)
- **Shelves** (individual shelf levels)
- **Items** (catalog products with UUIDs)

The full [JSON schema is here](./guideline.document.schema.response.json).

**Your task:** Build a recommendation model that suggests optimal left/right product placements for the top 10 most frequent items.

### Target Items (Top 10 by frequency)
```
1771c4a1-d902-11e4-a7e5-0025904e7aec
1797ef88-d902-11e4-a7e5-0025904e7aec
17c45bee-d902-11e4-a7e5-0025904e7aec
31377edb-bc97-11ec-80d8-028cc0c9a267
1964dca0-bc97-11ec-80d8-028cc0c9a267
1797e209-d902-11e4-a7e5-0025904e7aec
d5d8df12-c3a1-11eb-a03c-064c87f59bd9
9df3b27c-c3a1-11eb-a03c-064c87f59bd9
b82c22c1-5b7d-11ed-b2f6-028cc0c9a267
5b65d592-6041-11ed-b2f6-028cc0c9a267
```

## Technical Requirements

### Core Deliverables
1. **Data Processing Pipeline**
- Parse JSON guideline documents
- Extract spatial relationships between items
- Handle data quality issues and edge cases

2. **ML Model Implementation**
- Algorithm choice with clear justification
- Training pipeline with proper validation
- Hyperparameter optimization approach

3. **Recommendation API**
- Function: `get_recommendations(item_uuid) -> {"left": [items], "right": [items]}`
- Include confidence scores
- Handle unseen items gracefully

4. **Documentation & Code Quality**
- Clean, modular, testable code
- README with setup instructions
- Model performance analysis

### Technical Constraints
- **Language:** Python preferred (other languages acceptable with justification)
- **Libraries:** Use any ML/data science libraries

## Evaluation Criteria

- **Model Performance:** Recommendation quality and validation approach
- **Code Quality:** Maintainability, testing, documentation
- **Data Engineering:** Robust parsing and feature extraction
- **Technical Choices:** Algorithm selection and justification
- **Scalability:** Considerations for production deployment
- **Innovation:** Creative approaches to feature engineering or model design

## Data Details

- **Format:** JSON files following provided schema
- **Size:** ~6,000 documents
- **Structure:** [JSON schema](./guideline.document.schema.response.json).
- **Delivery:** Secure channel (details provided separately)

## Deliverable Format

The deliverable format is free. Keep in mind you will present it.

### Presentation (15 minutes)
1. **Problem Understanding** (5 min): How you interpreted the challenge
2. **Technical Approach** (15~20 min): Data processing, model choice, validation
3. **Results & Limitations** (10 min): Performance metrics, next steps
4. **Q&A** (5 min): Discussion of trade-offs and extensions

## Success Indicators

- **Functional:** Model produces sensible recommendations for all target items
- **Technical:** Clean, well-documented code with proper error handling
- **Analytical:** Clear validation methodology and performance metrics
- **Communication:** Articulate explanation of choices and trade-offs

## Questions?

Feel free to ask clarifying questions - part of the evaluation includes how you handle ambiguous requirements and make reasonable assumptions.