import Box from '@mui/material/Box'
import Button from '@mui/material/Button'
import Card from '@mui/material/Card'
import CardContent from '@mui/material/CardContent'
import Checkbox from '@mui/material/Checkbox'
import Container from '@mui/material/Container'
import List from '@mui/material/List'
import ListItem from '@mui/material/ListItem'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemText from '@mui/material/ListItemText'
import Typography from '@mui/material/Typography'
import { useRouter } from 'next/router'
import { useState, useEffect } from 'react'
import Error from '@/components/Error'
import Loading from '@/components/Loading'

export default function CompanyList() {
  const router = useRouter()
  const [companyData, setCompanyData] = useState([])
  const [selectedCompanies, setSelectedCompanies] = useState([])
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState(false)

  useEffect(() => {
    const fetchCompanyData = async () => {
      setLoading(true)
      try {
        const response = await fetch(
          'https://jsonplaceholder.typicode.com/photos',
        )
        if (!response.ok) {
          throw new Error('Failed to fetch')
        }
        const data = await response.json()
        setCompanyData(data)
        setLoading(false)
      } catch (error) {
        console.error('Error fetching data:', error)
        setError(true)
        setLoading(false)
      }
    }

    fetchCompanyData()
  }, [])

  if (loading) {
    return <Loading />
  }

  if (error) {
    return <Error />
  }

  const handleToggle = (value) => {
    const currentIndex = selectedCompanies.indexOf(value)
    const newChecked = [...selectedCompanies]

    if (currentIndex === -1) {
      newChecked.push(value)
    } else {
      newChecked.splice(currentIndex, 1)
    }

    setSelectedCompanies(newChecked)
  }

  const handleSubmit = async () => {
    try {
      const response = await fetch('http://localhost:8000/test', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          selectedCompanies,
        }),
      })

      if (!response.ok) {
        throw new Error('Something went wrong')
      }

      const data = await response.json()
      console.log(data)
      alert('Submission successful')
    } catch (error) {
      console.error('Failed to submit companies:', error)
      alert('Failed to submit')
    }
  }

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2 }}
      >
        オススメ会社一覧
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4 }}
      >
        あなたが気になる会社を選ぼう
      </Typography>
      <Container maxWidth="md">
        <List
          sx={{
            width: '100%',
            bgcolor: 'background.paper',
            overflow: 'auto',
          }}
        >
          {companyData.map((company) => (
            <Card key={company.company_id} sx={{ mb: 4, p: 2 }}>
              <CardContent>
                <ListItem disablePadding>
                  <ListItemButton
                    role={undefined}
                    onClick={() => handleToggle(company.company_id)}
                    dense
                  >
                    <Checkbox
                      edge="start"
                      checked={
                        selectedCompanies.indexOf(company.company_id) !== -1
                      }
                      tabIndex={-1}
                      disableRipple
                    />
                    <ListItemText
                      primary={company.company_name}
                      sx={{ textAlign: 'center' }}
                      primaryTypographyProps={{ variant: 'h6' }}
                    />
                  </ListItemButton>
                </ListItem>
              </CardContent>
            </Card>
          ))}
        </List>
        <Box sx={{ display: 'flex', justifyContent: 'center', mt: 4 }}>
          <Button variant="contained" color="primary" onClick={handleSubmit}>
            提出
          </Button>
        </Box>
      </Container>
    </Box>
  )
}
